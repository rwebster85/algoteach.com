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

use ReflectionClass;
use ReflectionMethod;
use RichPHPTests\Attributes;
use RichPHPTests\TestUtil;
use RichPHPTests\TestsConfiguration;

abstract class TestCase
{
    /**
     * The array of all the test methods that will be called.
     * 
     * @var string[]
     */
    private array $testMethods = [];
    
    /**
     * The array of all excluded tests found in the test class.
     * 
     * @var array
     */
    private array $excluded_tests = [];

    /**
     * Set to true on build if there is a setUp() method in the test class.
     * 
     * @var bool|null
     */
    private ?bool $hasTestSetUp;

    /**
     * Set to true on build if there is a tearDown() method in the test class.
     * 
     * @var bool|null
     */
    private ?bool $hasTestTearDown;

    /**
     * Set to true when all the tests are ready to be run.
     * 
     * @var bool
     */
    private bool $built = false;

    /**
     * Set to true when the tests int eh test class have all run.
     * 
     * @var bool
     */
    private bool $hasRun = false;

    /**
     * Accepts a TestsConfiguration object to assign excluded test methods for this test class.
     * 
     * @uses TestCase::$excluded_tests
     * 
     * @param TestsConfiguration $config
     */
    final public function __construct(TestsConfiguration $config)
    {
        $this->excluded_tests = $config->getExcludedTests();
        $this->buildTests();
        $this->run();
        //print("TestCase constructed." . PHP_EOL);
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

    private function runTest(string $method): void
    {
        $this->runBeforeTest($method);
        $this->{$method}();
        $this->runAfterTest($method);
    }

    private function runBeforeTest(string $method): void
    {
        $reflect = new ReflectionMethod($this, $method);
        $before = $reflect->getAttributes('RichPHPTests\Attributes\TestHasBefore');
        $before = !empty($before) ? $before[0] : '';
        if ($before) {
            $method_before = $before->getArguments();
            $method_before = !empty($method_before) ? $method_before[0] : null;
            if (
                $method_before
                && method_exists($this, $method_before)
                && TestUtil::testClassHasMethod(new ReflectionMethod($this, $method_before))
            ) {
                $this->{$method_before}();
            }
        }
    }

    private function runAfterTest(string $method): void
    {
        $reflect = new ReflectionMethod($this, $method);
        $after = $reflect->getAttributes('RichPHPTests\Attributes\TestHasBefore');
        $after = !empty($after) ? $after[0] : '';
        if ($after) {
            $method_after = $after->getArguments();
            $method_after = !empty($method_after) ? $method_after[0] : null;
            if (
                $method_after
                && method_exists($this, $method_after)
                && TestUtil::testClassHasMethod(new ReflectionMethod($this, $method_after))
            ) {
                $this->{$method_after}();
            }
        }
    }

    /**
     * Calls the setUpClass() method only if it is declared in the test class.
     * 
     * @uses TestCase::setUpClass()
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
     * Calls the tearDownClass() method only if it is declared in the test class.
     * 
     * @uses TestCase::tearDownClass()
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
     * Runs before each test and calls setUp() only if that method exists in the test class.
     * 
     * Stores in TestCase::$hasTestSetUp whether a valid setUp is to be used.
     * 
     * @uses TestCase::setUp()
     * 
     * @return void
     */
    private function doSetup(): void
    {
        if (!isset($this->hasTestSetUp)) {
            $method = new ReflectionMethod($this, 'setUp');
            $this->hasTestSetUp = (
                TestUtil::testClassHasMethod($method)
                && $method->getReturnType()->getName() === 'void'
            );
        }

        if ($this->hasTestSetUp == true) {
            $this->setUp();
        }
    }

    /**
     * Runs after each test and calls tearDown() only if that method exists in the test class.
     * 
     * Stores in TestCase::$hasTestTearDown whether a valid tearDown is to be used.
     * 
     * @uses TestCase::tearDown()
     * 
     * @return void
     */
    private function doTearDown(): void
    {
        if (!isset($this->hasTestTearDown)) {
            $method = new ReflectionMethod($this, 'setUp');
            $this->hasTestTearDown = (
                TestUtil::testClassHasMethod($method)
                && $method->getReturnType()->getName() === 'void'
            );
        }

        if ($this->hasTestTearDown == true) {
            $this->tearDown();
        }
    }

    /**
     * Creates an array of all valid test methods to call on the test class.
     * 
     * Checks to see if any are in the config excluded tests array.
     * 
     * @uses TestUtil::isTestMethod()
     * @uses TestCase::$excluded_tests
     * 
     * @return void
     */
    private function buildTests(): void
    {
        if ($this->built == true ) {
            return;
        }

        $reflection_class = new ReflectionClass($this);
        $methods = $reflection_class->getMethods(ReflectionMethod::IS_PUBLIC);
        foreach ($methods as $method) {
            if (TestUtil::isTestMethod($method)) {
                $test_name = $reflection_class->getName() . '::' . $method->getName();
                if (!$this->isTestSkipped($test_name, $method)) {
                    $this->addMethod($method);
                } else {
                    Application::getTestResults()->addSkippedTest();
                }
            }
        }

        $this->built = true;
    }

    private function isTestSkipped(string $test_name, ReflectionMethod $method): bool
    {
        return (in_array($test_name, $this->excluded_tests) || TestUtil::hasSkippedAttribute($method));
    }

    private function addMethod(ReflectionMethod $method): void
    {
        $this->testMethods[] = $method->getName();
    }

    /**
     * Iterates through the test methods and calls each one. Also calls all the setUp tearDown checking methods. 
     * 
     * @uses TestCase::$excluded_tests
     * @uses TestCase::doSetUpClass()
     * @uses TestCase::doSetup()
     * @uses TestCase::doTearDown()
     * @uses TestCase::doTearDownClass()
     * 
     * @return void
     */
    private function run(): void
    {
        if ($this->hasRun == true) {
            return;
        }

        $this->doSetUpClass();

        foreach ($this->testMethods as $method) {
            if (method_exists($this, $method)) {
                $this->doSetup();
                $this->runTest($method);
                $this->doTearDown();
            }
        }

        $this->doTearDownClass();

        $this->hasRun = true;
    }
}
