<?php

declare(strict_types=1);

use RichPHPTests\TestCase;

class SomeTest2 extends TestCase
{
    public function testIsTrue(): void
    {
        test(true)->isTrue();
    }

    public function testIsFalse(): void
    {
        test(false)->isFalse();
    }
}
