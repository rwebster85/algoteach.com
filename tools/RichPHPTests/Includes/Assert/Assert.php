<?php

declare(strict_types=1);

namespace RichPHPTests\Assert;

use RichPHPTests\TestResult;

use RichPHPTests\Assert\Traits\AssertArrayTrait;
use RichPHPTests\Assert\Traits\AssertBoolTrait;
use RichPHPTests\Assert\Traits\AssertEqualityTrait;
use RichPHPTests\Assert\Traits\AssertNumericTrait;
use RichPHPTests\Assert\Traits\AssertObjectTrait;
use RichPHPTests\Assert\Traits\AssertStringTrait;

abstract class Assert
{
    use AssertArrayTrait;
    use AssertBoolTrait;
    use AssertEqualityTrait;
    use AssertNumericTrait;
    use AssertObjectTrait;
    use AssertStringTrait;

    private static function assert(mixed $value, mixed $expected, string $error_message): void
    {
        $pass = ($value === $expected);
        (new TestResult($value, $expected, $error_message, $pass));
    }
}
