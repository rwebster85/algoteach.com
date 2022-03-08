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
    private bool $is_cli = false;

    private static ?Application $instance = null;

    public int $code = -1;

    private static TestResults $test_results;

    private TestSuite $test_suite;

    private ?TestsConfiguration $configuration = null;

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
        $this->test_suite = new TestSuite($this->configuration);
        
        self::$test_results = new TestResults();
    }

    private function run(): void
    {
        $this->code = 2;
        $args = [];

        if ($this->is_cli) {
            $args = $_SERVER['argv'];
        }

        if ($this->is_cli) {
            print('Running test suite: ' . $this->configuration->getName() . PHP_EOL);
        }

        $bootstrap = $this->configuration->getBootstrap();
        if (file_exists($bootstrap)) {
            include_once $bootstrap;
        }

        $this->test_suite->run();

        //var_dump($args);
    }

    public static function getTestResults(): TestResultsInterface
    {
        return self::$test_results;
    }

    private function parseArgs(mixed $args): void
    {

    }

    public function getExit(): void
    {
        //$exit_desc = AppErrors::tryFrom($this->code);
        //return (
        //    !is_null($exit_desc)
        //    ? $exit_desc->getErrorDesc()
        //    : ''
        //);
    }
}
