<?php

declare(strict_types=1);

namespace RichPHPTests;

use ReflectionClass;
use RichPHPTests\Assert\Assert;
use RichPHPTests\TestUtil;
use ReflectionMethod;

abstract class TestCase extends Assert
{
    private array $testMethods = [];

    public int $some_var;

    public function __construct() {}

    public function run(): void
    {
        foreach ($this->testMethods as $method) {
            if (method_exists($this, $method)) {
                $this->{$method}();
            }
        }
    }

    public function buildTests(): void
    {
        $methods = (new ReflectionClass($this))->getMethods(ReflectionMethod::IS_PUBLIC);
        foreach ($methods as $method) {
            //$reflection_method = new ReflectionMethod($this, $method);
            if (TestUtil::isTestMethod($method)) {
                $this->addMethod($method);
            }
        }
    }

    private function addMethod(ReflectionMethod $method): void
    {
        $this->testMethods[] = $method->getName();
    }
}
