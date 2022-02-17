<?php

declare(strict_types=1);

namespace RichPHPTests;

use ReflectionClass;
use RichPHPTests\Assert\Assert;
use RichPHPTests\TestUtil;
use ReflectionMethod;
use ReflectionObject;

abstract class TestCase extends Assert
{
    private array $testMethods = [];

    public function __construct() {}

    /**
     * Runs before any tests are carried out for the class.
     * 
     * @return void
     */
    public function setUpClass(): void {}

    /**
     * Runs after all tests are carried out for the class.
     * 
     * @return void
     */
    public function tearDownClass(): void {}

    /**
     * Runs before each test is carried out.
     * 
     * @return void
     */
    protected function setUp(): void {}

    /**
     * Runs after each test is carried out.
     * 
     * @return void
     */
    protected function tearDown(): void {}

    public function run(): void
    {
        $this->doSetUpClass();

        foreach ($this->testMethods as $method) {
            if (method_exists($this, $method)) {
                $this->doSetup();
                $this->{$method}();
                $this->doTearDown();
            }
        }

        $this->doTearDownClass();
    }

    /**
     * Calls the `setUpClass()` method only if it is declared in the test class.
     * 
     * @return void
     */
    private function doSetUpClass(): void
    {
        if (TestUtil::testClassHasMethod(new ReflectionMethod($this, 'setUpClass'))) {
            $this->setUpClass();
        }
    }

    /**
     * Calls the `tearDownClass()` method only if it is declared in the test class.
     * 
     * @return void
     */
    private function doTearDownClass(): void
    {
        if (TestUtil::testClassHasMethod(new ReflectionMethod($this, 'tearDownClass'))) {
            $this->tearDownClass();
        }
    }

    /**
     * Runs before each test and calls `setUp()` only if that method exists in the test class.
     * 
     * @return void
     */
    private function doSetup(): void
    {
        if (TestUtil::testClassHasMethod(new ReflectionMethod($this, 'setUp'))) {
            $this->setUp();
        }
    }

    /**
     * Runs after each test and calls `tearDown()` only if that method exists in the test class.
     * 
     * @return void
     */
    private function doTearDown(): void
    {
        if (TestUtil::testClassHasMethod(new ReflectionMethod($this, 'tearDown'))) {
            $this->tearDown();
        }
    }

    public function buildTests(): void
    {
        $methods = (new ReflectionClass($this))->getMethods(ReflectionMethod::IS_PUBLIC);
        foreach ($methods as $method) {
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
