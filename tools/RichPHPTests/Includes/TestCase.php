<?php

declare(strict_types=1);

namespace RichPHPTests;

use ReflectionClass;
use RichPHPTests\Assert\Assert;
use RichPHPTests\TestUtil;
use ReflectionMethod;
use RichPHPTests\TestsConfiguration;

abstract class TestCase extends Assert
{
    private array $testMethods = [];
    
    private array $excluded_tests = [];

    public function __construct(TestsConfiguration $config)
    {
        $this->excluded_tests = $config->getExcludedTests();
    }

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
        $method = new ReflectionMethod($this, 'setUpClass');
        if (
            TestUtil::testClassHasMethod(new ReflectionMethod($this, 'setUpClass'))
            && $method->getReturnType()->getName() === 'void'
        ) {
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
        $method = new ReflectionMethod($this, 'tearDownClass');
        if (
            TestUtil::testClassHasMethod(new ReflectionMethod($this, 'setUpClass'))
            && $method->getReturnType()->getName() === 'void'
        ) {
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
        $method = new ReflectionMethod($this, 'setUp');

        if (
            TestUtil::testClassHasMethod($method)
            && $method->getReturnType()->getName() === 'void'
        ) {
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
        $method = new ReflectionMethod($this, 'tearDown');

        if (
            TestUtil::testClassHasMethod($method)
            && $method->getReturnType()->getName() === 'void'
        ) {
            $this->tearDown();
        }
    }

    public function buildTests(): void
    {
        $reflection_class = new ReflectionClass($this);
        $methods = $reflection_class->getMethods(ReflectionMethod::IS_PUBLIC);
        foreach ($methods as $method) {
            if (TestUtil::isTestMethod($method)) {
                $test_name = $reflection_class->getName() . '::' . $method->getName();
                if (!in_array($test_name, $this->excluded_tests)) {
                    $this->addMethod($method);
                } else {
                    Application::getTestResults()->addSkippedTest();
                }
            }
        }
    }

    private function addMethod(ReflectionMethod $method): void
    {
        $this->testMethods[] = $method->getName();
    }
}
