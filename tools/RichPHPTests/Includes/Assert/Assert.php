<?php

declare(strict_types=1);

namespace RichPHPTests\Assert;

use RichPHPTests\TestResult;

abstract class Assert
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

    protected static function assertTrue(mixed $value): void
    {
        static::assert($value, true, 'Value is not TRUE.');
    }

    protected static function assertFalse(mixed $value): void
    {
        static::assert($value, false, 'Value is not FALSE.');
    }

    protected static function assertIsBool(mixed $value): void
    {
        static::assert(is_bool($value), true, 'Value is not a boolean.');
    }

    protected static function assertIsNotBool(mixed $value): void
    {
        static::assert(is_bool($value), false, 'Value is a boolean.');
    }

    protected static function assertEquals(mixed $value, mixed $condition): void
    {
        static::assert($value, $condition, 'Values are not the same.');
    }

    protected static function assertNotEquals(mixed $value, mixed $condition): void
    {
        $not_equals = ($value !== $condition);
        static::assert($not_equals, true, 'Values are the same.');
    }

    protected static function assertIsInt(mixed $value): void
    {
        static::assert(is_int($value), true, 'Value is not an integer.');
    }

    protected static function assertIsNotInt(mixed $value): void
    {
        static::assert(is_int($value), false, 'Value is an integer.');
    }

    protected static function assertIsFloat(mixed $value): void
    {
        static::assert(is_float($value), true, 'Value is not a float.');
    }

    protected static function assertIsNotFloat(mixed $value): void
    {
        static::assert(is_float($value), false, 'Value is a float.');
    }

    protected static function assertIsObject(mixed $value): void
    {
        static::assert(is_object($value), true, 'Value is not an object.');
    }

    protected static function assertIsNotObject(mixed $value): void
    {
        static::assert(is_object($value), false, 'Value is an object.');
    }

    protected static function assertIsString(mixed $value): void
    {
        static::assert(is_string($value), true, 'Value is not a string.');
    }

    protected static function assertIsNotString(mixed $value): void
    {
        static::assert(is_string($value), false, 'Value is a string.');
    }

    protected static function assertStringsMatch(string $string1, string $string2): void
    {
        static::assert($string1, $string2, 'Strings are not the same.');
    }

    protected static function assertStringsNotMatch(string $string1, string $string2): void
    {
        $not_match = ($string1 !== $string2);
        static::assert($not_match, true, 'Strings are the same.');
    }

    protected static function assertStringContains(string $needle, string $haystack): void
    {
        static::assert(str_contains($haystack, $needle), true, 'String does not contain needle.');
    }

    protected static function assertStringNotContains(string $needle, string $haystack): void
    {
        static::assert(str_contains($haystack, $needle), false, 'String does contain needle.');
    }

    private static function assert(mixed $value, mixed $expected, string $error_message): void
    {
        $pass = ($value === $expected);
        (new TestResult($value, $expected, $error_message, $pass));
    }
}
