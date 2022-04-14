<?php

/*
 * This file is part of RichPHPTests.
 *
 * Copyright (c) Richard Webster
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace RichPHPTests;

use ReflectionMethod;

class TestResult
{
    /**
     * The line number the test method appears on.
     * 
     * @var string
     */
    public string $line;

    /**
     * The name of the test method.
     * 
     * @var string
     */
    public string $test_name;

    /**
     * The class name the test belongs to.
     * 
     * @var string
     */
    public string $test_class;

    /**
     * The filename containing the test.
     * 
     * @var string
     */
    public string $test_file;

    public function __construct(
        public mixed $actual,
        public mixed $expected,
        public string $error_message,
        private bool $pass
    ) {
        $trace = debug_backtrace()[3];

        $this->test_name = ($trace['function'] ?? '');
        $this->test_class = ($trace['class'] ?? '');

        if ($this->test_name && $this->test_class) {
            $reflection_method = new ReflectionMethod(
                $this->test_class, $this->test_name
            );
            $this->line = strval($reflection_method->getStartLine());
            $this->test_file = $reflection_method->getFileName();
        }

        Application::getTestResults()->addResult($this);
    }

    public function errorMessage(): string
    {
        return $this->error_message;
    }

    public function testPassed(): bool
    {
        return $this->pass;
    }

    /**
     * Generates a string representation for output of the passed in the variable.
     * 
     * Bools become 'true' or 'false', numbers as string versions, and strings are wrapped in single quotes.
     * 
     * @param mixed $var
     * 
     * @return string
     */
    public function parseVarForOutput(mixed $var): string
    {
        return match(gettype($var)) {
            'boolean'           => ($var === true ? 'true' : 'false'),
            'integer', 'double' => (string) $var,
            'string'            => "'" . $var . "'",
            default             => ''
        };
    }
}
