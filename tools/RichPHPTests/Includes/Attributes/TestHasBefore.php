<?php

declare(strict_types=1);

namespace RichPHPTests\Attributes;

use \Attribute;

class TestHasBefore
{
    public function __construct(string $methodToRun) {}
}
