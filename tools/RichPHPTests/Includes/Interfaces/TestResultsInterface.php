<?php

declare(strict_types=1);

namespace RichPHPTests\Interfaces;

use RichPHPTests\TestResult;

interface TestResultsInterface
{
    public function addResult(TestResult $result): void;

    public function addSkippedFile(): void;

    public function addSkippedTest(): void;

    public function getResults(): array;

    public function getTotalPassed(): int;

    public function getTotalFailed(): int;

    public function getTotalTests(): int;

    public function getSkippedFiles(): int;

    public function getSkippedTests(): int;

    public function printResults(): void;
}
