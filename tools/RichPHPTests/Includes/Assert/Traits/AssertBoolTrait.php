<?php

declare(strict_types=1);

namespace RichPHPTests\Assert\Traits;

trait AssertBoolTrait
{
    protected static function assertTrue(mixed $value): void
    {
        static::assertThat($value, true, 'Value is not TRUE.');
    }

    protected static function assertFalse(mixed $value): void
    {
        static::assertThat($value, false, 'Value is not FALSE.');
    }

    protected static function assertIsBool(mixed $value): void
    {
        static::assertThat(is_bool($value), true, 'Value is not a boolean.');
    }

    protected static function assertIsNotBool(mixed $value): void
    {
        static::assertThat(is_bool($value), false, 'Value is a boolean.');
    }
}
