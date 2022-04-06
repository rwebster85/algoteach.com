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

use RichPHPTests\Interfaces\TestResultsInterface;

use const PHP_EOL;
use const DIRECTORY_SEPARATOR;

final class TestResults implements TestResultsInterface
{
    /**
     * Array of key/value pairs of results. Key is the name of the class tested, value is an array of TestResult objects.
     * 
     * @uses TestResult
     * 
     * @var array<string, TestResult[]>
     */
    private array $results = [];

    private int $total_tests = 0;

    private int $total_pass = 0;

    private int $total_fail = 0;

    private int $skipped_files = 0;

    private int $skipped_tests = 0;

    public function __construct(
        private TestSuite $suite
    ) {}

    public function addResult(TestResult $result): void
    {
        $this->results[$result->test_class][] = $result;

        $this->total_tests++;

        if ($result->testPassed()) {
            $this->total_pass++;
        } else {
            $this->total_fail++;
        }
    }

    public function addSkippedFile(): void
    {
        $this->skipped_files++;
    }

    public function addSkippedTest(): void
    {
        $this->skipped_tests++;
    }

    /**
     * Returns an array of key value pairs. Key is the name of the class tested, value is an array of TestResult objects.
     * 
     * @return array<string, TestResult[]>
     */
    public function getResults(): array
    {
        return $this->results;
    }

    public function getTotalPassed(): int
    {
        return $this->total_pass;
    }

    public function getTotalFailed(): int
    {
        return $this->total_fail;
    }

    public function getTotalTests(): int
    {
        return $this->total_tests;
    }

    public function getSkippedFiles(): int
    {
        return $this->skipped_files;
    }

    public function getSkippedTests(): int
    {
        return $this->skipped_tests;
    }

    public function printResults(): void
    {
        $results = $this->getResults();

        //var_dump($results);

        $total_tests = $this->getTotalTests();
        $total_pass = $this->getTotalPassed();
        $total_fail = $this->getTotalFailed();
        $total_skipped = $this->getSkippedFiles();
        $total_skipped_tests = $this->getSkippedTests();

        $instantiated_tests = $this->suite->getInstantiatedTestsCount();
        $invalid_tests = $this->suite->getInvalidTestClasses();

        print("Test classes: $instantiated_tests, Tests ran: $total_tests, Passed: $total_pass, Failed: $total_fail. Skipped Files: $total_skipped - Skipped Tests: $total_skipped_tests" . PHP_EOL);

        if (!empty($invalid_tests)) {
            $count = count($invalid_tests);
            $message = ($count > 1 ? 'files were' : 'file was');
            echo sprintf(
                '%1$s invalid test %2$s encountered.' . PHP_EOL,
                $count,
                $message
            );
            foreach ($invalid_tests as $invalid) {
                $the_class = $invalid['class'];
                assert($the_class instanceof TestClass);
                $reason = (string) $invalid['reason'];
                $qualified_name = $the_class->qualifiedClassName();
                print("'$qualified_name' - $reason." . PHP_EOL);
            }
        }

        if ($total_fail > 0) {
            print("The following tests failed:" . PHP_EOL);
            /** @var TestClass $tested_class */
            foreach ($results as $tested_class) {
                /** @var TestResult $result */
                foreach ($tested_class as $result) {
                    if (!$result->testPassed()) {
                        $class    = $result->test_class;
                        $test     = $result->test_name;
                        $line     = $result->line;
                        $error    = $result->errorMessage();
                        $expected = $result->parseVarForOutput($result->expected);
                        $actual   = $result->parseVarForOutput($result->actual);
                        $file     = substr($result->test_file, strrpos($result->test_file, DIRECTORY_SEPARATOR) + 1);
                        print("$class::$test : File: $file - Line: $line - Expected: $expected - Actual: $actual - Error: $error" . PHP_EOL);
                    }
                }
            }
        }
    }
}
