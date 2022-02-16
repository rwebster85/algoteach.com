<?php

declare(strict_types=1);

namespace RichPHPTests\Assert\Traits;

trait AssertNumericTrait
{
    protected static function assertIsInt(mixed $value): void
    {
        static::assertThat(is_int($value), true, 'Value is not an integer.');
    }

    protected static function assertIsNotInt(mixed $value): void
    {
        static::assertThat(is_int($value), false, 'Value is an integer.');
    }

    protected static function assertIsFloat(mixed $value): void
    {
        static::assertThat(is_float($value), true, 'Value is not a float.');
    }

    protected static function assertIsNotFloat(mixed $value): void
    {
        static::assertThat(is_float($value), false, 'Value is a float.');
    }
}
