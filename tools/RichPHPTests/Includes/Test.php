<?php

declare(strict_types=1);

namespace RichPHPTests;

use RichPHPTests\Abstracts\AbstractTest;

final class Test extends AbstractTest
{
    final public function __construct(
        private mixed $value
    ) {}

    public function isArray(): void
    {
        $this->assert(is_array($this->value), true, 'Value is not an array.');
    }

    public function isNotArray(mixed $value): void
    {
        $this->assert(is_array($this->value), false, 'Value is an array.');
    }

    public function arrayHasKey(mixed $key): void
    {
        $this->assert(array_key_exists($key, $this->value), true, 'Key not found in array.');
    }

    public function arrayNotHasKey(mixed $key): void
    {
        $this->assert(array_key_exists($key, $this->value), false, 'Key was found in array.');
    }

    public function arrayHasValue(mixed $needle): void
    {
        $has_value = in_array($needle, $this->value, true);
        $this->assert($has_value, true, 'Value not found in array.');
    }

    public function arrayNotHasValue(mixed $needle): void
    {
        $has_value = in_array($needle, $this->value, true);
        $this->assert($has_value, false, 'Value was found in array.');
    }

    public function arrayIsSize(int $size): void
    {
        $this->assert(count($this->value), $size, 'Array is not the right size.');
    }

    public function isTrue(): void
    {
        $this->assert($this->value, true, 'Value is not TRUE.');
    }

    public function isFalse(): void
    {
        $this->assert($this->value, false, 'Value is not FALSE.');
    }

    public function isBool(): void
    {
        $this->assert(is_bool($this->value), true, 'Value is not a boolean.');
    }

    public function isNotBool(): void
    {
        $this->assert(is_bool($this->value), false, 'Value is a boolean.');
    }

    public function equals(mixed $condition): void
    {
        $this->assert($this->value, $condition, 'Values are not the same.');
    }

    public function notEquals(mixed $condition): void
    {
        $not_equals = ($this->value !== $condition);
        $this->assert($not_equals, true, 'Values are the same.');
    }

    public function isInt(): void
    {
        $this->assert(is_int($this->value), true, 'Value is not an integer.');
    }

    public function isNotInt(): void
    {
        $this->assert(is_int($this->value), false, 'Value is an integer.');
    }

    public function isFloat(): void
    {
        $this->assert(is_float($this->value), true, 'Value is not a float.');
    }

    public function isNotFloat(): void
    {
        $this->assert(is_float($this->value), false, 'Value is a float.');
    }

    public function isObject(): void
    {
        $this->assert(is_object($this->value), true, 'Value is not an object.');
    }

    public function isNotObject(): void
    {
        $this->assert(is_object($this->value), false, 'Value is an object.');
    }

    public function isString(): void
    {
        $this->assert(is_string($this->value), true, 'Value is not a string.');
    }

    public function isNotString(): void
    {
        $this->assert(is_string($this->value), false, 'Value is a string.');
    }

    public function stringMatches(string $other): void
    {
        $this->assert($this->value, $other, 'Strings are not the same.');
    }

    public function stringNotMatch(string $other): void
    {
        $not_match = ($this->value !== $other);
        $this->assert($not_match, true, 'Strings are the same.');
    }

    public function stringContains(string $needle): void
    {
        $this->assert(str_contains($this->value, $needle), true, 'String does not contain needle.');
    }

    public function stringNotContains(string $needle): void
    {
        $this->assert(str_contains($this->value, $needle), false, 'String does contain needle.');
    }

    private function assert(mixed $value, mixed $expected, string $error_message): void
    {
        $pass = ($value === $expected);
        (new TestResult($value, $expected, $error_message, $pass));
    }
}
