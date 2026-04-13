<?php

declare(strict_types=1);

namespace Fr3on\Ruleset\Parser;

/**
 * An 'IN' operation (e.g., 'x IN [1, 2, 3]').
 */
final readonly class InNode implements Node
{
    /**
     * @param array<Node> $elements
     */
    public function __construct(
        public Node $left,
        public array $elements
    ) {}
}
