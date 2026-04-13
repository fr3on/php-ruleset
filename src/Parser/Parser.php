<?php

declare(strict_types=1);

namespace Fr3on\Ruleset\Parser;

use Fr3on\Ruleset\Lexer\Token;
use Fr3on\Ruleset\Lexer\TokenType;
use Fr3on\Ruleset\Exceptions\ParseException;

/**
 * Recursive descent parser for the Ruleset language.
 */
final class Parser
{
    /** @var list<Token> */
    private array $tokens = [];
    private int $current = 0;

    /**
     * @param list<Token> $tokens
     */
    public function parse(array $tokens): Node
    {
        $this->tokens = $tokens;
        $this->current = 0;

        return $this->parseLogicalOr();
    }

    // OR -> AND
    private function parseLogicalOr(): Node
    {
        $node = $this->parseLogicalAnd();

        while ($this->match(TokenType::OR)) {
            $prev = $this->previous();
            $val = $prev->type->value;
            $operator = is_scalar($val) ? (string)$val : '';
            $right = $this->parseLogicalAnd();
            $node = new BinaryOpNode($operator, $node, $right);
        }

        return $node;
    }

    // AND -> NOT
    private function parseLogicalAnd(): Node
    {
        $node = $this->parseLogicalNot();

        while ($this->match(TokenType::AND)) {
            $prev = $this->previous();
            $val = $prev->type->value;
            $operator = is_scalar($val) ? (string)$val : '';
            $right = $this->parseLogicalNot();
            $node = new BinaryOpNode($operator, $node, $right);
        }

        return $node;
    }

    // NOT -> Comparison
    private function parseLogicalNot(): Node
    {
        if ($this->match(TokenType::NOT)) {
            $operator = 'NOT';
            $node = $this->parseLogicalNot();
            return new UnaryOpNode($operator, $node);
        }

        return $this->parseComparison();
    }

    // Comparison -> Term
    private function parseComparison(): Node
    {
        $node = $this->parseTerm();

        while ($this->match(TokenType::EQ, TokenType::NEQ, TokenType::GT, TokenType::GTE, TokenType::LT, TokenType::LTE, TokenType::IN)) {
            $prev = $this->previous();
            $val = $prev->type->value;
            $operator = is_scalar($val) ? (string)$val : '';
            
            if ($operator === 'IN') {
                $node = $this->parseIn($node);
            } else {
                $right = $this->parseTerm();
                $node = new BinaryOpNode($operator, $node, $right);
            }
        }

        return $node;
    }

    private function parseIn(Node $left): Node
    {
        $this->consume(TokenType::LBRACKET, "Expect '[' after 'IN'.");
        $elements = [];

        if (!$this->check(TokenType::RBRACKET)) {
            do {
                $elements[] = $this->parseLogicalOr();
            } while ($this->match(TokenType::COMMA));
        }

        $this->consume(TokenType::RBRACKET, "Expect ']' after IN list.");

        return new InNode($left, $elements);
    }

    // Term -> Factor (+, -)
    private function parseTerm(): Node
    {
        $node = $this->parseFactor();

        while ($this->match(TokenType::PLUS, TokenType::MINUS)) {
            $prev = $this->previous();
            $val = $prev->value;
            $operator = is_scalar($val) ? (string)$val : '';
            $right = $this->parseFactor();
            $node = new BinaryOpNode($operator, $node, $right);
        }

        return $node;
    }

    // Factor -> Unary (*, /)
    private function parseFactor(): Node
    {
        $node = $this->parseUnary();

        while ($this->match(TokenType::STAR, TokenType::SLASH)) {
            $prev = $this->previous();
            $val = $prev->value;
            $operator = is_scalar($val) ? (string)$val : '';
            $right = $this->parseUnary();
            $node = new BinaryOpNode($operator, $node, $right);
        }

        return $node;
    }

    // Unary -> Primary
    private function parseUnary(): Node
    {
        if ($this->match(TokenType::MINUS)) {
            $operator = '-';
            $node = $this->parseUnary();
            return new UnaryOpNode($operator, $node);
        }

        return $this->parsePrimary();
    }

    // Primary -> Atoms, Parens, Functions
    private function parsePrimary(): Node
    {
        if ($this->match(TokenType::NULL)) return new LiteralNode(null);
        if ($this->match(TokenType::BOOL)) return new LiteralNode($this->previous()->value);
        if ($this->match(TokenType::NUMBER)) return new LiteralNode($this->previous()->value);
        if ($this->match(TokenType::STRING)) return new LiteralNode($this->previous()->value);

        if ($this->match(TokenType::IDENTIFIER)) {
            $prev = $this->previous();
            $val = $prev->value;
            $name = is_scalar($val) ? (string)$val : '';
            
            // Check for function call
            if ($this->match(TokenType::LPAREN)) {
                return $this->parseFunctionCall($name);
            }
            
            return new IdentifierNode($name);
        }

        if ($this->match(TokenType::LPAREN)) {
            $node = $this->parseLogicalOr();
            $this->consume(TokenType::RPAREN, "Expect ')' after expression.");
            return $node;
        }

        throw new ParseException(sprintf(
            "Expect expression at position %d, found '%s'",
            $this->peek()->position,
            $this->peek()->type->name
        ));
    }

    private function parseFunctionCall(string $name): Node
    {
        $arguments = [];
        if (!$this->check(TokenType::RPAREN)) {
            do {
                $arguments[] = $this->parseLogicalOr();
            } while ($this->match(TokenType::COMMA));
        }

        $this->consume(TokenType::RPAREN, "Expect ')' after function arguments.");

        return new FunctionCallNode($name, $arguments);
    }

    // --- Helpers ---

    private function match(TokenType ...$types): bool
    {
        foreach ($types as $type) {
            if ($this->check($type)) {
                $this->advance();
                return true;
            }
        }

        return false;
    }

    private function consume(TokenType $type, string $message): Token
    {
        if ($this->check($type)) return $this->advance();

        throw new ParseException($message);
    }

    private function check(TokenType $type): bool
    {
        if ($this->isAtEnd()) return false;
        return $this->peek()->type === $type;
    }

    private function advance(): Token
    {
        if (!$this->isAtEnd()) $this->current++;
        return $this->previous();
    }

    private function isAtEnd(): bool
    {
        return $this->peek()->type === TokenType::EOF;
    }

    private function peek(): Token
    {
        return $this->tokens[$this->current];
    }

    private function previous(): Token
    {
        return $this->tokens[$this->current - 1];
    }
}
