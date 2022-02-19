<?php

declare(strict_types=1);

namespace RichPHPTests\Attributes;

use \Attribute;

class TestHasAfter
{
    public function __construct(string $methodToRun) {}
}
