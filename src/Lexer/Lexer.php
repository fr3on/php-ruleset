<?php

declare(strict_types=1);

namespace Fr3on\Ruleset\Lexer;

use Fr3on\Ruleset\Exceptions\ParseException;

/**
 * Tokenizes raw business rule strings into a list of Tokens.
 */
final class Lexer
{
    private int $position = 0;
    private string $input = '';

    /**
     * @return list<Token>
     * @throws ParseException
     */
    public function tokenize(string $input): array
    {
        $this->input = $input;
        $this->position = 0;
        $tokens = [];

        while ($this->position < strlen($this->input)) {
            $char = $this->input[$this->position];

            // Skip whitespace
            if (ctype_space($char)) {
                $this->position++;
                continue;
            }

            // Identifiers / Keywords
            if (ctype_alpha($char) || $char === '_') {
                $tokens[] = $this->readIdentifier();
                continue;
            }

            // Numbers
            if (ctype_digit($char)) {
                $tokens[] = $this->readNumber();
                continue;
            }

            // Strings
            if ($char === '"' || $char === "'") {
                $tokens[] = $this->readString($char);
                continue;
            }

            // Operators & Delimiters
            $operator = $this->readOperator();
            if ($operator !== null) {
                $tokens[] = $operator;
                continue;
            }

            throw new ParseException(sprintf(
                "Unexpected character '%s' at position %d",
                $char,
                $this->position
            ));
        }

        $tokens[] = new Token(TokenType::EOF, position: $this->position);

        return $tokens;
    }

    private function readIdentifier(): Token
    {
        $start = $this->position;
        $identifier = '';

        while ($this->position < strlen($this->input)) {
            $char = $this->input[$this->position];
            // Identifiers can contain alphanumeric characters, underscore, and dots for path resolution
            if (ctype_alnum($char) || $char === '_' || $char === '.') {
                $identifier .= $char;
                $this->position++;
            } else {
                break;
            }
        }

        // Check for keywords
        $upper = strtoupper($identifier);
        
        return match ($upper) {
            'AND' => new Token(TokenType::AND, 'AND', $start),
            'OR' => new Token(TokenType::OR, 'OR', $start),
            'NOT' => new Token(TokenType::NOT, 'NOT', $start),
            'IN' => new Token(TokenType::IN, 'IN', $start),
            'TRUE' => new Token(TokenType::BOOL, true, $start),
            'FALSE' => new Token(TokenType::BOOL, false, $start),
            'NULL' => new Token(TokenType::NULL, null, $start),
            default => new Token(TokenType::IDENTIFIER, $identifier, $start),
        };
    }

    private function readNumber(): Token
    {
        $start = $this->position;
        $number = '';
        $hasDot = false;

        while ($this->position < strlen($this->input)) {
            $char = $this->input[$this->position];
            if (ctype_digit($char)) {
                $number .= $char;
                $this->position++;
            } elseif ($char === '.' && !$hasDot && $this->position + 1 < strlen($this->input) && ctype_digit($this->input[$this->position + 1])) {
                $hasDot = true;
                $number .= $char;
                $this->position++;
            } else {
                break;
            }
        }

        return new Token(
            TokenType::NUMBER,
            $hasDot ? (float)$number : (int)$number,
            $start
        );
    }

    private function readString(string $quote): Token
    {
        $start = $this->position;
        $this->position++; // skip start quote
        $string = '';

        while ($this->position < strlen($this->input)) {
            $char = $this->input[$this->position];
            if ($char === $quote) {
                $this->position++;
                return new Token(TokenType::STRING, $string, $start);
            }
            
            // Basic escape support
            if ($char === '\\' && $this->position + 1 < strlen($this->input)) {
                $this->position++;
                $string .= $this->input[$this->position];
            } else {
                $string .= $char;
            }
            
            $this->position++;
        }

        throw new ParseException("Unterminated string starting at position " . $start);
    }

    private function readOperator(): ?Token
    {
        $start = $this->position;
        
        // Two-character operators
        if ($this->position + 1 < strlen($this->input)) {
            $twoChars = substr($this->input, $this->position, 2);
            $type = match ($twoChars) {
                '!=' => TokenType::NEQ,
                '>=' => TokenType::GTE,
                '<=' => TokenType::LTE,
                default => null,
            };

            if ($type !== null) {
                $this->position += 2;
                return new Token($type, $twoChars, $start);
            }
        }

        // One-character operators
        $char = $this->input[$this->position];
        $type = match ($char) {
            '=' => TokenType::EQ,
            '>' => TokenType::GT,
            '<' => TokenType::LT,
            '+' => TokenType::PLUS,
            '-' => TokenType::MINUS,
            '*' => TokenType::STAR,
            '/' => TokenType::SLASH,
            '(' => TokenType::LPAREN,
            ')' => TokenType::RPAREN,
            '[' => TokenType::LBRACKET,
            ']' => TokenType::RBRACKET,
            ',' => TokenType::COMMA,
            '.' => TokenType::DOT,
            default => null,
        };

        if ($type !== null) {
            $this->position++;
            return new Token($type, $char, $start);
        }

        return null;
    }
}
