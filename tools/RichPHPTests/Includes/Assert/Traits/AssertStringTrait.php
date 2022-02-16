<?php

declare(strict_types=1);

namespace RichPHPTests\Assert\Traits;

trait AssertStringTrait
{
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
}
