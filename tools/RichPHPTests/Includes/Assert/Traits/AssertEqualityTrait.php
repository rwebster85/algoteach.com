<?php

declare(strict_types=1);

namespace RichPHPTests\Assert\Traits;

trait AssertEqualityTrait
{
    protected static function assertEquals(mixed $value, mixed $condition): void
    {
        static::assertThat($value, $condition, 'Values are not the same.');
    }

    protected static function assertNotEquals(mixed $value, mixed $condition): void
    {
        $not_equals = ($value !== $condition);
        static::assertThat($not_equals, true, 'Values are the same.');
    }
}
