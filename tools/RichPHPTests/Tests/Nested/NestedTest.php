<?php

declare(strict_types=1);

use RichPHPTests\TestCase;

class NestedTest extends TestCase
{
    public function testIsTrue(): void
    {
        test(true)->isTrue();
    }

    public function testIsFalse(): void
    {
        test(false)->isFalse();
    }

    public function testInArray(): void
    {
        $array = ['hello', 'world'];
        test($array)->arrayHasValue('hello');
    }
}
