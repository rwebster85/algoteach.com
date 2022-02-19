<?php

declare(strict_types=1);

namespace RichPHPTests\Abstracts;

abstract class AbstractTest
{
    final public function __construct(
        protected mixed $value
    ) {}
}
