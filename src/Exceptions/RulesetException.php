<?php

declare(strict_types=1);

namespace Fr3on\Ruleset\Exceptions;

use Exception;

/**
 * Base exception for the Ruleset library.
 */
class RulesetException extends Exception {}

/**
 * Thrown when the lexer or parser encounters invalid syntax.
 */
final class ParseException extends RulesetException {}

/**
 * Thrown when a rule evaluation fails (e.g. type mismatch).
 */
final class EvaluationException extends RulesetException {}

/**
 * Thrown when an unsafe identifier or function is encountered.
 */
final class UnsafeExpressionException extends RulesetException {}
