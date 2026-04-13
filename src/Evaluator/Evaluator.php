<?php

declare(strict_types=1);

namespace Fr3on\Ruleset\Evaluator;

use Fr3on\Ruleset\Parser\Node;
use Fr3on\Ruleset\Parser\LiteralNode;
use Fr3on\Ruleset\Parser\IdentifierNode;
use Fr3on\Ruleset\Parser\BinaryOpNode;
use Fr3on\Ruleset\Parser\UnaryOpNode;
use Fr3on\Ruleset\Parser\FunctionCallNode;
use Fr3on\Ruleset\Parser\InNode;
use Fr3on\Ruleset\Exceptions\EvaluationException;

/**
 * Walks the AST and evaluates it against a Context.
 */
final class Evaluator
{
    public function __construct(
        private readonly Functions $functions = new Functions()
    ) {}

    public function evaluate(Node $node, Context $context): mixed
    {
        return match (true) {
            $node instanceof LiteralNode => $node->value,
            $node instanceof IdentifierNode => $context->resolve($node->name),
            $node instanceof BinaryOpNode => $this->evaluateBinary($node, $context),
            $node instanceof UnaryOpNode => $this->evaluateUnary($node, $context),
            $node instanceof FunctionCallNode => $this->evaluateFunction($node, $context),
            $node instanceof InNode => $this->evaluateIn($node, $context),
            default => throw new EvaluationException("Unsupported node type: " . get_class($node)),
        };
    }

    private function evaluateBinary(BinaryOpNode $node, Context $context): mixed
    {
        $left = $this->evaluate($node->left, $context);
        
        // Lazy evaluation for logical operators
        if ($node->operator === 'AND') {
            return (bool)$left && (bool)$this->evaluate($node->right, $context);
        }
        if ($node->operator === 'OR') {
            return (bool)$left || (bool)$this->evaluate($node->right, $context);
        }

        $right = $this->evaluate($node->right, $context);

        return match ($node->operator) {
            '=' => (is_numeric($left) && is_numeric($right)) ? $left == $right : $left === $right,
            '!=' => (is_numeric($left) && is_numeric($right)) ? $left != $right : $left !== $right,
            '>' => $left > $right,
            '>=' => $left >= $right,
            '<' => $left < $right,
            '<=' => $left <= $right,
            '+' => $this->performMath($left, '+', $right),
            '-' => $this->performMath($left, '-', $right),
            '*' => $this->performMath($left, '*', $right),
            '/' => $this->performMath($left, '/', $right),
            default => throw new EvaluationException("Unsupported operator: " . $node->operator),
        };
    }

    private function performMath(mixed $left, string $op, mixed $right): int|float
    {
        if (!is_numeric($left) || !is_numeric($right)) {
            throw new EvaluationException(sprintf(
                "Math operation '%s' requires numeric types, found '%s' and '%s'.",
                $op,
                gettype($left),
                gettype($right)
            ));
        }

        return match ($op) {
            '+' => $left + $right,
            '-' => $left - $right,
            '*' => $left * $right,
            '/' => $right == 0 ? throw new EvaluationException("Division by zero.") : $left / $right,
            default => throw new EvaluationException("Unsupported math operator: " . $op),
        };
    }

    private function evaluateUnary(UnaryOpNode $node, Context $context): mixed
    {
        $value = $this->evaluate($node->node, $context);

        return match ($node->operator) {
            'NOT' => !(bool)$value,
            '-' => is_numeric($value) ? -$value : throw new EvaluationException("Unary minus requires numeric type."),
            default => throw new EvaluationException("Unsupported unary operator: " . $node->operator),
        };
    }

    private function evaluateFunction(FunctionCallNode $node, Context $context): mixed
    {
        $args = array_map(fn($n) => $this->evaluate($n, $context), $node->arguments);
        return $this->functions->call($node->name, $args);
    }

    private function evaluateIn(InNode $node, Context $context): bool
    {
        $left = $this->evaluate($node->left, $context);
        $elements = array_map(fn($n) => $this->evaluate($n, $context), $node->elements);

        return in_array($left, $elements, true);
    }
}
