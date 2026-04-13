<?php

declare(strict_types=1);

namespace Fr3on\Ruleset;

use Fr3on\Ruleset\Lexer\Lexer;
use Fr3on\Ruleset\Parser\Parser;
use Fr3on\Ruleset\Parser\Node;
use Fr3on\Ruleset\Evaluator\Context;
use Fr3on\Ruleset\Evaluator\Functions;
use Fr3on\Ruleset\Evaluator\Evaluator;
use Fr3on\Ruleset\Exceptions\RulesetException;

/**
 * Main entry point for the Ruleset library.
 */
final class Ruleset
{
    private readonly Lexer $lexer;
    private readonly Parser $parser;
    private readonly Evaluator $evaluator;
    private readonly Functions $functions;

    public function __construct()
    {
        $this->lexer = new Lexer();
        $this->parser = new Parser();
        $this->functions = new Functions();
        $this->evaluator = new Evaluator($this->functions);
    }

    /**
     * Parses an expression string into an AST Node.
     * 
     * @throws RulesetException
     */
    public function parse(string $expression): Node
    {
        $tokens = $this->lexer->tokenize($expression);
        return $this->parser->parse($tokens);
    }

    /**
     * Evaluates a pre-parsed AST node against a data context.
     * 
     * @param array<string, mixed> $data
     * @throws RulesetException
     */
    public function evaluate(Node $node, array $data = []): mixed
    {
        $context = new Context($data);
        return $this->evaluator->evaluate($node, $context);
    }

    /**
     * Parse and evaluate in one go (shortcut).
     * 
     * @param array<string, mixed> $data
     * @throws RulesetException
     */
    public function execute(string $expression, array $data = []): mixed
    {
        $node = $this->parse($expression);
        return $this->evaluate($node, $data);
    }

    /**
     * Registers a custom function for use in expressions.
     */
    public function registerFunction(string $name, callable $callback): void
    {
        $this->functions->register($name, $callback);
    }

    /**
     * Static helper for quick evaluation.
     * 
     * @param array<string, mixed> $data
     * @throws RulesetException
     */
    public static function eval(string $expression, array $data = []): mixed
    {
        return (new self())->execute($expression, $data);
    }
}
