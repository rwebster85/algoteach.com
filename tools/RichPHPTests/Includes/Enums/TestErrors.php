<?php

declare(strict_types=1);

namespace RichPHPTests\Enums;

enum TestErrors: string
{
    case AssertTrue = 'Value is not TRUE.';
    case AssertFalse = 'Value is not FALSE.';
}
