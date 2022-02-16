<?php

declare(strict_types=1);

namespace RichPHPTests\Assert\Traits;

trait AssertObjectTrait
{
    protected static function assertIsObject(mixed $value): void
    {
        static::assertThat(is_object($value), true, 'Value is not an object.');
    }

    protected static function assertIsNotObject(mixed $value): void
    {
        static::assertThat(is_object($value), false, 'Value is an object.');
    }
}
