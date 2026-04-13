<?php

declare(strict_types=1);

namespace Fr3on\Ruleset\Parser;

/**
 * A literal value (string, number, bool, null).
 */
final readonly class LiteralNode implements Node
{
    public function __construct(public mixed $value) {}
}
