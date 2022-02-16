<?php

declare(strict_types=1);

namespace RichPHPTests\Assert\Traits;

trait AssertArrayTrait
{
    protected static function assertIsArray(mixed $value): void
    {
        static::assert(is_array($value), true, 'Value is not an array.');
    }

    protected static function assertIsNotArray(mixed $value): void
    {
        static::assert(is_array($value), false, 'Value is an array.');
    }

    protected static function assertArrayHasKey(mixed $key, array $array): void
    {
        static::assert(array_key_exists($key, $array), true, 'Key not found in array.');
    }

    protected static function assertArrayNotHasKey(mixed $key, array $array): void
    {
        static::assert(array_key_exists($key, $array), false, 'Key was found in array.');
    }

    protected static function assertArrayHasValue(mixed $needle, array $haystack): void
    {
        $has_value = in_array($needle, $haystack, true);
        static::assert($has_value, true, 'Value not found in array.');
    }

    protected static function assertArrayHasNotValue(mixed $needle, array $haystack): void
    {
        $has_value = in_array($needle, $haystack, true);
        static::assert($has_value, false, 'Value was found in array.');
    }

    protected static function assertArrayIsSize(array $array, int $size): void
    {
        static::assert(count($array), $size, 'Array is not the right size.');
    }
}
