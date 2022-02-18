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

    private ?bool $hasTestSetUp;

    private ?bool $hasTestTearDown;

    /**
     * Accepts a TestsConfiguration object to assign excluded test methods for this test class.
     * 
     * @uses TestCase::$excluded_tests
     * 
     * @param TestsConfiguration $config
     */
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
