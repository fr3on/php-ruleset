<?php

declare(strict_types=1);

namespace Fr3on\Ruleset\Lexer;

/**
 * Supported tokens for the Ruleset expression language.
 */
enum TokenType: string
{
    // Logical
    case AND = 'AND';
    case OR = 'OR';
    case NOT = 'NOT';

    // Comparison
    case EQ = '=';
    case NEQ = '!=';
    case GT = '>';
    case GTE = '>=';
    case LT = '<';
    case LTE = '<=';
    case IN = 'IN';

    // Arithmetic
    case PLUS = '+';
    case MINUS = '-';
    case STAR = '*';
    case SLASH = '/';

    // Access & Delimiters
    case DOT = '.';
    case COMMA = ',';
    case LPAREN = '(';
    case RPAREN = ')';
    case LBRACKET = '[';
    case RBRACKET = ']';

    // Literals & Identifiers
    case STRING = 'STRING';
    case NUMBER = 'NUMBER';
    case BOOL = 'BOOL';
    case NULL = 'NULL';
    case IDENTIFIER = 'IDENTIFIER';
    
    // End of string
    case EOF = 'EOF';
}
