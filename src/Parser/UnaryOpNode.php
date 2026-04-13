<?php

declare(strict_types=1);

namespace Fr3on\Ruleset\Parser;

/**
 * A unary operation (e.g., '-at', 'NOT checked').
 */
final readonly class UnaryOpNode implements Node
{
    public function __construct(
        public string $operator,
        public Node $node
    ) {}
}
