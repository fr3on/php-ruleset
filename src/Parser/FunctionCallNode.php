<?php

declare(strict_types=1);

namespace Fr3on\Ruleset\Parser;

/**
 * A function call (e.g., 'upper(name)').
 */
final readonly class FunctionCallNode implements Node
{
    /**
     * @param array<Node> $arguments
     */
    public function __construct(
        public string $name,
        public array $arguments
    ) {}
}
