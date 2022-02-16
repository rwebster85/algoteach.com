<?php

declare(strict_types=1);

namespace RichPHPTests\Enums;

enum AppErrors: int
{
    case DEFAULT = 0;
    case EXCEPTION = 1;

    public function getErrorDesc(): string
    {
        return match($this) {
            self::DEFAULT => 'No error.',
            self::EXCEPTION => 'Exception thrown.',
        };
    }
}
