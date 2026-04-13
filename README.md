# php-ruleset

A standalone, framework-agnostic PHP 8.4+ expression and business rule evaluator. Secure, fast, and 100% type-safe (PHPStan Level 9).

## Features

- **Recursive Descent Parser**: Pure AST-based evaluation (no `eval()`).
- **Secure by Design**: Strict whitelist for all identifiers and functions.
- **Dot-Notation**: Easily resolve nested data like `user.profile.age`.
- **Zero Dependencies**: 100% standalone.
- **PHP 8.4+**: Leverages property hooks and readonly classes.

## Installation

```bash
composer require fr3on/php-ruleset
```

## Quick Start

```php
use Fr3on\Ruleset\Ruleset;

$ruleset = new Ruleset();

$rule = 'order.total * 1.15 > 1000 AND user.country IN ["SA", "AE"]';
$data = [
    'order' => ['total' => 1000],
    'user' => ['country' => 'SA']
];

$result = $ruleset->execute($rule, $data); // true
```

## Advanced Usage

### Custom Functions

```php
$ruleset->registerFunction('is_premium', fn($userId) => $db->isPremium($userId));

$ruleset->execute('is_premium(user.id) AND order.discount > 0.2', $data);
```

### Pre-parsing & Caching

For high-performance scenarios, parse the expression once and cache the AST.

```php
$ast = $ruleset->parse('x > 10');

// Reuse $ast across many evaluations
$result = $ruleset->evaluate($ast, ['x' => 15]);
```

## Security

RuleSet uses a strict whitelist approach.
1. All identifiers must exist in the provided context.
2. Only whitelisted functions can be called.
3. Math operations enforce numeric types strictly.

## License

MIT
