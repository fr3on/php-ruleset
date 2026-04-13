<?php declare(strict_types = 1);

// odsl-/Users/fr3on/Documents/0x200/php/php-ruleset/src/Lexer/Lexer.php-PHPStan\BetterReflection\Reflection\ReflectionClass-Fr3on\Ruleset\Lexer\Lexer
return \PHPStan\Cache\CacheItem::__set_state(array(
   'variableKey' => 'v2-6.70.0.0-8.5.4-c192591ce51371b6fc745bf5a0176dd67d18a9a780c1bded3c8df6ab1cb2eb5f',
   'data' => 
  array (
    'locatedSource' => 
    array (
      'class' => 'PHPStan\\BetterReflection\\SourceLocator\\Located\\LocatedSource',
      'data' => 
      array (
        'name' => 'Fr3on\\Ruleset\\Lexer\\Lexer',
        'filename' => '/Users/fr3on/Documents/0x200/php/php-ruleset/src/Lexer/Lexer.php',
      ),
    ),
    'namespace' => 'Fr3on\\Ruleset\\Lexer',
    'name' => 'Fr3on\\Ruleset\\Lexer\\Lexer',
    'shortName' => 'Lexer',
    'isInterface' => false,
    'isTrait' => false,
    'isEnum' => false,
    'isBackedEnum' => false,
    'modifiers' => 32,
    'docComment' => '/**
 * Tokenizes raw business rule strings into a list of Tokens.
 */',
    'attributes' => 
    array (
    ),
    'startLine' => 12,
    'endLine' => 204,
    'startColumn' => 1,
    'endColumn' => 1,
    'parentClassName' => NULL,
    'implementsClassNames' => 
    array (
    ),
    'traitClassNames' => 
    array (
    ),
    'immediateConstants' => 
    array (
    ),
    'immediateProperties' => 
    array (
      'position' => 
      array (
        'declaringClassName' => 'Fr3on\\Ruleset\\Lexer\\Lexer',
        'implementingClassName' => 'Fr3on\\Ruleset\\Lexer\\Lexer',
        'name' => 'position',
        'modifiers' => 4,
        'type' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'int',
            'isIdentifier' => true,
          ),
        ),
        'default' => 
        array (
          'code' => '0',
          'attributes' => 
          array (
            'startLine' => 14,
            'endLine' => 14,
            'startTokenPos' => 38,
            'startFilePos' => 229,
            'endTokenPos' => 38,
            'endFilePos' => 229,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 14,
        'endLine' => 14,
        'startColumn' => 5,
        'endColumn' => 30,
        'isPromoted' => false,
        'declaredAtCompileTime' => true,
        'immediateVirtual' => false,
        'immediateHooks' => 
        array (
        ),
      ),
      'input' => 
      array (
        'declaringClassName' => 'Fr3on\\Ruleset\\Lexer\\Lexer',
        'implementingClassName' => 'Fr3on\\Ruleset\\Lexer\\Lexer',
        'name' => 'input',
        'modifiers' => 4,
        'type' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'string',
            'isIdentifier' => true,
          ),
        ),
        'default' => 
        array (
          'code' => '\'\'',
          'attributes' => 
          array (
            'startLine' => 15,
            'endLine' => 15,
            'startTokenPos' => 49,
            'startFilePos' => 260,
            'endTokenPos' => 49,
            'endFilePos' => 261,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 15,
        'endLine' => 15,
        'startColumn' => 5,
        'endColumn' => 31,
        'isPromoted' => false,
        'declaredAtCompileTime' => true,
        'immediateVirtual' => false,
        'immediateHooks' => 
        array (
        ),
      ),
    ),
    'immediateMethods' => 
    array (
      'tokenize' => 
      array (
        'name' => 'tokenize',
        'parameters' => 
        array (
          'input' => 
          array (
            'name' => 'input',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'string',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 21,
            'endLine' => 21,
            'startColumn' => 30,
            'endColumn' => 42,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'array',
            'isIdentifier' => true,
          ),
        ),
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * @return list<Token>
 * @throws ParseException
 */',
        'startLine' => 21,
        'endLine' => 71,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => true,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Fr3on\\Ruleset\\Lexer',
        'declaringClassName' => 'Fr3on\\Ruleset\\Lexer\\Lexer',
        'implementingClassName' => 'Fr3on\\Ruleset\\Lexer\\Lexer',
        'currentClassName' => 'Fr3on\\Ruleset\\Lexer\\Lexer',
        'aliasName' => NULL,
      ),
      'readIdentifier' => 
      array (
        'name' => 'readIdentifier',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'Fr3on\\Ruleset\\Lexer\\Token',
            'isIdentifier' => false,
          ),
        ),
        'attributes' => 
        array (
        ),
        'docComment' => NULL,
        'startLine' => 73,
        'endLine' => 102,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 4,
        'namespace' => 'Fr3on\\Ruleset\\Lexer',
        'declaringClassName' => 'Fr3on\\Ruleset\\Lexer\\Lexer',
        'implementingClassName' => 'Fr3on\\Ruleset\\Lexer\\Lexer',
        'currentClassName' => 'Fr3on\\Ruleset\\Lexer\\Lexer',
        'aliasName' => NULL,
      ),
      'readNumber' => 
      array (
        'name' => 'readNumber',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'Fr3on\\Ruleset\\Lexer\\Token',
            'isIdentifier' => false,
          ),
        ),
        'attributes' => 
        array (
        ),
        'docComment' => NULL,
        'startLine' => 104,
        'endLine' => 129,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 4,
        'namespace' => 'Fr3on\\Ruleset\\Lexer',
        'declaringClassName' => 'Fr3on\\Ruleset\\Lexer\\Lexer',
        'implementingClassName' => 'Fr3on\\Ruleset\\Lexer\\Lexer',
        'currentClassName' => 'Fr3on\\Ruleset\\Lexer\\Lexer',
        'aliasName' => NULL,
      ),
      'readString' => 
      array (
        'name' => 'readString',
        'parameters' => 
        array (
          'quote' => 
          array (
            'name' => 'quote',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'string',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 131,
            'endLine' => 131,
            'startColumn' => 33,
            'endColumn' => 45,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'Fr3on\\Ruleset\\Lexer\\Token',
            'isIdentifier' => false,
          ),
        ),
        'attributes' => 
        array (
        ),
        'docComment' => NULL,
        'startLine' => 131,
        'endLine' => 156,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => true,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 4,
        'namespace' => 'Fr3on\\Ruleset\\Lexer',
        'declaringClassName' => 'Fr3on\\Ruleset\\Lexer\\Lexer',
        'implementingClassName' => 'Fr3on\\Ruleset\\Lexer\\Lexer',
        'currentClassName' => 'Fr3on\\Ruleset\\Lexer\\Lexer',
        'aliasName' => NULL,
      ),
      'readOperator' => 
      array (
        'name' => 'readOperator',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionUnionType',
          'data' => 
          array (
            'types' => 
            array (
              0 => 
              array (
                'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
                'data' => 
                array (
                  'name' => 'Fr3on\\Ruleset\\Lexer\\Token',
                  'isIdentifier' => false,
                ),
              ),
              1 => 
              array (
                'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
                'data' => 
                array (
                  'name' => 'null',
                  'isIdentifier' => true,
                ),
              ),
            ),
          ),
        ),
        'attributes' => 
        array (
        ),
        'docComment' => NULL,
        'startLine' => 158,
        'endLine' => 203,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 4,
        'namespace' => 'Fr3on\\Ruleset\\Lexer',
        'declaringClassName' => 'Fr3on\\Ruleset\\Lexer\\Lexer',
        'implementingClassName' => 'Fr3on\\Ruleset\\Lexer\\Lexer',
        'currentClassName' => 'Fr3on\\Ruleset\\Lexer\\Lexer',
        'aliasName' => NULL,
      ),
    ),
    'traitsData' => 
    array (
      'aliases' => 
      array (
      ),
      'modifiers' => 
      array (
      ),
      'precedences' => 
      array (
      ),
      'hashes' => 
      array (
      ),
    ),
  ),
));