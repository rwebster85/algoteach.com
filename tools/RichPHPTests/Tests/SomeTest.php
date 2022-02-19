<?php

declare(strict_types=1);

use RichPHPTests\TestCase;
use RichPHPTests\Attributes;

class SomeTest extends TestCase
{
    #[Attributes\TestHasBefore('runBeforeTestIsTrue')]
    #[Attributes\TestHasAfter('runAfterTestIsTrue')]
    public function testIsTrue(): void
    {
        $this->assertTrue(true);
    }

    public function runBeforeTestIsTrue(): void
    {
        print('We ran before' . PHP_EOL);
    }

    public function runAfterTestIsTrue(): void
    {
        print('We ran after' . PHP_EOL);
    }

    public function testIsFalse(): void
    {
        $this->assertFalse(false);
    }

    public function testStringMatches(): void
    {
        $this->assertStringsMatch('String1', 'String1');
    }

    public function testStringMatches2(): void
    {
        $this->assertStringsMatch('String2', 'String2');
    }

    public function testStringNotMatch(): void
    {
        $this->assertStringsNotMatch('String1', 'String2');
    }

    public function testIsArray(): void
    {
        $this->assertIsArray([]);
    }

    public function testIsNotArray(): void
    {
        $this->assertIsNotArray(2);
    }

    public function testArrayIsEmpty(): void
    {
        $this->assertArrayIsSize([], 0);
    }

    public function testArrayHas2Elements(): void
    {
        $this->assertArrayIsSize([1, 2], 2);
    }
}
