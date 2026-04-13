<?php

declare(strict_types=1);

namespace Fr3on\Ruleset\Evaluator;

use Fr3on\Ruleset\Exceptions\UnsafeExpressionException;

/**
 * Registry of whitelisted functions for use in expressions.
 */
final class Functions
{
    /** @var array<string, callable> */
    private array $functions = [];

    public function __construct()
    {
        $this->registerDefaults();
    }

    public function register(string $name, callable $callback): void
    {
        $this->functions[strtolower($name)] = $callback;
    }

    /**
     * @param array<int, mixed> $arguments
     */
    public function call(string $name, array $arguments): mixed
    {
        $lowerName = strtolower($name);
        if (!isset($this->functions[$lowerName])) {
            throw new UnsafeExpressionException(sprintf("Unknown function '%s'.", $name));
        }

        return ($this->functions[$lowerName])(...$arguments);
    }

    private function registerDefaults(): void
    {
        // String
        $this->register('upper', fn(mixed $v) => strtoupper($this->safeString($v)));
        $this->register('lower', fn(mixed $v) => strtolower($this->safeString($v)));
        $this->register('len', fn(mixed $v) => is_array($v) ? count($v) : strlen($this->safeString($v)));
        
        // Math
        $this->register('round', fn(mixed $v) => round($this->safeFloat($v)));
        $this->register('floor', fn(mixed $v) => floor($this->safeFloat($v)));
        $this->register('ceil', fn(mixed $v) => ceil($this->safeFloat($v)));
        
        // Date
        $this->register('now', fn() => time());
        $this->register('date', fn(mixed $v) => strtotime($this->safeString($v)));
        
        // Coercion
        $this->register('int', fn(mixed $v) => (int)(is_scalar($v) ? $v : 0));
        $this->register('float', fn(mixed $v) => (float)(is_scalar($v) ? $v : 0.0));
        $this->register('str', fn(mixed $v) => $this->safeString($v));
        $this->register('bool', fn(mixed $v) => (bool)$v);
    }

    private function safeString(mixed $v): string
    {
        if (is_scalar($v) || $v === null) {
            return (string)$v;
        }
        return '';
    }

    private function safeFloat(mixed $v): float
    {
        if (is_numeric($v)) {
            return (float)$v;
        }
        return 0.0;
    }
}
