<?php

declare(strict_types=1);

namespace MyUnitTests;

use RichPHPTests\TestCase;

class SomeTest2 extends TestCase
{
    public function testIsTrue(): void
    {
        $this->assertTrue(true);
    }

    public function testIsFalse(): void
    {
        $this->assertFalse(false);
    }

    public function testStringMatches(): void
    {
        $this->assertStringsMatch('String1', 'String2');
    }
}
