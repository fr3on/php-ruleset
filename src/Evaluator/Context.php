<?php

declare(strict_types=1);

namespace Fr3on\Ruleset\Evaluator;

use Fr3on\Ruleset\Exceptions\EvaluationException;

/**
 * Resolves dot-notation paths against input data (arrays/objects).
 */
final readonly class Context
{
    /**
     * @param array<string, mixed> $data
     */
    public function __construct(
        private array $data = [],
        private bool $strict = false
    ) {}

    /**
     * Creates a strict context that throws on missing paths.
     * 
     * @param array<string, mixed> $data
     */
    public static function strict(array $data): self
    {
        return new self($data, true);
    }

    /**
     * Resolves a dot-path (e.g., 'user.profile.id').
     */
    public function resolve(string $path): mixed
    {
        if ($path === '' || $path === '.') {
            return $this->data;
        }

        $parts = explode('.', $path);
        $current = $this->data;

        foreach ($parts as $part) {
            if (is_array($current) && array_key_exists($part, $current)) {
                $current = $current[$part];
                continue;
            }

            if (is_object($current)) {
                if (isset($current->{$part})) {
                    $current = $current->{$part};
                    continue;
                }
                
                $getter = 'get' . ucfirst($part);
                if (method_exists($current, $getter)) {
                    $current = $current->$getter();
                    continue;
                }
            }

            if ($this->strict) {
                throw new EvaluationException(sprintf("Path '%s' not found in context.", $path));
            }

            return null;
        }

        return $current;
    }
}
