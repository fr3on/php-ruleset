<?php

declare(strict_types=1);

namespace Fr3on\Ruleset\Parser;

/**
 * An identifier referring to a context path (e.g., 'user.name').
 */
final readonly class IdentifierNode implements Node
{
    public function __construct(public string $name) {}
}
