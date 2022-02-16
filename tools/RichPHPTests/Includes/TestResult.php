<?php

declare(strict_types=1);

namespace RichPHPTests;

use ReflectionMethod;

class TestResult
{
    public string $line;

    public string $test_name;

    public string $test_class;

    public string $test_file;

    public function __construct(
        public mixed $actual,
        public mixed $expected,
        public string $error_message,
        private bool $pass
    ) {
        $trace = debug_backtrace()[3];

        $this->test_name = $trace['function'] ?? '';
        $this->test_class = $trace['class'] ?? '';

        if ($this->test_name && $this->test_class) {
            $reflection_method = new ReflectionMethod($this->test_class, $this->test_name);
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

    public function parseVarForOutput(mixed $var): string
    {
        return match(gettype($var)) {
            'boolean' => ($var === true ? 'true' : 'false'),
            'integer', 'double' => (string) $var,
            'string'  => "'" . $var . "'",
            default => ''
        };
    }
}
