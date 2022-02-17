<?php

declare(strict_types=1);

namespace RichPHPTests;

use RichPHPTests\Interfaces\TestResultsInterface;

use const PHP_EOL;
use const DIRECTORY_SEPARATOR;

final class TestResults implements TestResultsInterface
{
    private array $results = [];

    private int $total_tests = 0;

    private int $total_pass = 0;

    private int $total_fail = 0;

    private int $skipped_files = 0;

    private int $skipped_tests = 0;

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

        $total_tests = $this->getTotalTests();
        $total_pass = $this->getTotalPassed();
        $total_fail = $this->getTotalFailed();
        $total_skipped = $this->getSkippedFiles();
        $total_skipped_tests = $this->getSkippedTests();

        print("Tests ran: {$total_tests}, Passed: {$total_pass}, Failed: {$total_fail}. Skipped Files: {$total_skipped} - Skipped Tests: {$total_skipped_tests}" . PHP_EOL);

        if ($total_fail > 0) {
            print("The following tests failed:" . PHP_EOL);
            foreach ($results as $class) {
                foreach ($class as $result) {
                    if (!$result->testPassed()) {
                        $class = $result->test_class;
                        $test = $result->test_name;
                        $line = $result->line;
                        $error = $result->errorMessage();
                        $expected = $result->parseVarForOutput($result->expected);
                        $actual = $result->parseVarForOutput($result->actual);
                        $file = substr($result->test_file, strrpos($result->test_file, DIRECTORY_SEPARATOR) + 1);
                        print("$class::$test : File: {$file} - Line: {$line} - Expected: {$expected} - Actual: {$actual} - Error: {$error}" . PHP_EOL);
                    }
                }
            }
        }
    }
}
