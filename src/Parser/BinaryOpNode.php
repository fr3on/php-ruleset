<?php

declare(strict_types=1);

namespace Fr3on\Ruleset\Parser;

/**
 * A binary operation (e.g., 'a + b', 'score > 10').
 */
final readonly class BinaryOpNode implements Node
{
    public function __construct(
        public string $operator,
        public Node $left,
        public Node $right
    ) {}
}
