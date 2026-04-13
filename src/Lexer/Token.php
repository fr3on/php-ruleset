<?php

declare(strict_types=1);

namespace Fr3on\Ruleset\Lexer;

/**
 * A lexical unit (Token) in the Ruleset language.
 */
final readonly class Token
{
    public function __construct(
        public TokenType $type,
        public mixed $value = null,
        public int $position = 0
    ) {}

    public function __toString(): string
    {
        $valueStr = match(true) {
            is_scalar($this->value) => (string)$this->value,
            is_null($this->value) => 'NULL',
            default => gettype($this->value),
        };
        return sprintf("[%s: %s]", $this->type->name, $valueStr);
    }
}
