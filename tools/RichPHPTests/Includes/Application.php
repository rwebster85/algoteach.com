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

use RichPHPTests\Enums\AppErrors;
use RichPHPTests\Enums\AppErrors as EnumsAppErrors;
use RichPHPTests\Interfaces\TestResultsInterface;

final class Application
{
    /**
     * Whether the application was launched from command line.
     * 
     * @var bool
     */
    private bool $is_cli = false;

    /**
     * Program uses the Singleton design pattern.
     * 
     * @var Application|null|null
     */
    private static ?Application $instance = null;

    /**
     * The storage of completed test results.
     * 
     * @var TestResults
     */
    private static TestResults $test_results;

    /**
     * The test suite object.
     * 
     * @var TestSuite
     */
    private TestSuite $test_suite;

    /**
     * The configuration object for the tests.
     * 
     * @var TestsConfiguration|null|null
     */
    private ?TestsConfiguration $configuration = null;

    /**
     * Singleton pattern application.
     * 
     * @param TestsConfiguration|null $config
     * 
     * @return self
     */
    public static function instance(?TestsConfiguration $config = null): self
    {
        if (is_null(self::$instance)) {
            self::$instance = new self($config);
            self::$instance->run();
        }
        return self::$instance;
    }

    private function __construct(?TestsConfiguration $config)
    {
        $this->is_cli = SourceChecker::isCli();
        $this->configuration = $config;
        $this->bootstrap();
        $this->test_suite = new TestSuite($this->configuration);
        self::$test_results = new TestResults($this->test_suite);
    }

    /**
     * Loads the test bootstrap file prior to running any tests.
     * 
     * @return void
     */
    private function bootstrap(): void
    {
        $bootstrap = $this->configuration->getBootstrap();
        if (file_exists($bootstrap)) {
            include_once $bootstrap;
        }
    }

    /**
     * Run from the instance() method. Runs the test suite.
     * 
     * @return void
     */
    private function run(): void
    {
        $args = [];

        if ($this->is_cli) {
            $args = $_SERVER['argv'];
        }

        if ($this->is_cli) {
            print('Running test suite: ' . $this->configuration->getName() . PHP_EOL);
            print('PHP Version: ' . PHP_VERSION . PHP_EOL);
        }

        $this->test_suite->run();
    }

    /**
     * Returns the object containing the completed test results.
     * 
     * @return TestResultsInterface
     */
    public static function getTestResults(): TestResultsInterface
    {
        return self::$test_results;
    }
}
