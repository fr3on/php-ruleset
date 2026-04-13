<?php

declare(strict_types=1);

namespace Fr3on\Ruleset\Tests\Integration;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use Fr3on\Ruleset\Ruleset;

class RulesetTest extends TestCase
{
    private Ruleset $ruleset;

    protected function setUp(): void
    {
        $this->ruleset = new Ruleset();
    }

    #[DataProvider('expressionProvider')]
    public function test_expressions(string $expression, array $data, mixed $expected): void
    {
        $this->assertSame($expected, $this->ruleset->execute($expression, $data));
    }

    public static function expressionProvider(): array
    {
        return [
            // Literals
            'null' => ['null', [], null],
            'true' => ['true', [], true],
            'false' => ['false', [], false],
            'integer' => ['123', [], 123],
            'float' => ['12.34', [], 12.34],
            'string' => ['"hello"', [], 'hello'],

            // Comparisons
            'equal' => ['1 = 1', [], true],
            'not equal' => ['1 != 2', [], true],
            'greater' => ['10 > 5', [], true],
            'less or equal' => ['5 <= 5', [], true],
            'in list true' => ['1 IN [1, 2, 3]', [], true],
            'in list false' => ['4 IN [1, 2, 3]', [], false],

            // Logic
            'and true' => ['true AND true', [], true],
            'and false' => ['true AND false', [], false],
            'or true' => ['true OR false', [], true],
            'not' => ['NOT true', [], false],
            'logic composition' => ['(true OR false) AND NOT false', [], true],

            // Math
            'addition' => ['10 + 20', [], 30],
            'composition' => ['10 + 20 * 2', [], 50],
            'parens' => ['(10 + 20) * 2', [], 60],
            'negative' => ['-10 + 20', [], 10],

            // Context (Dot Paths)
            'simple context' => ['user.name = "Ahmed"', ['user' => ['name' => 'Ahmed']], true],
            'nested context' => ['order.total > 100', ['order' => ['total' => 150]], true],
            'missing path' => ['user.age = null', ['user' => []], true],

            // Functions
            'len string' => ['len("abc") = 3', [], true],
            'len array' => ['len(items) = 2', ['items' => [1, 2]], true],
            'upper' => ['upper("hello") = "HELLO"', [], true],
            'round' => ['round(10.6) = 11', [], true],

            // Complex Business Rule
            'complex' => [
                'order.total * 1.15 > 1000 AND user.country IN ["SA", "AE"]',
                [
                    'order' => ['total' => 1000],
                    'user' => ['country' => 'SA']
                ],
                true
            ]
        ];
    }

    public function test_custom_function(): void
    {
        $this->ruleset->registerFunction('double', fn($v) => $v * 2);
        $this->assertSame(20, $this->ruleset->execute('double(10)'));
    }
}
