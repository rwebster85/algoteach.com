<?php

/*
 * This file is part of RichPHPTests.
 *
 * Copyright (c) Richard Webster
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace RichPHPTests\Attributes;

use Attribute;

/**
 * The Skip attribute can be applied to test classes or methods to have them excluded from the test run.
 * 
 * Example Usage:
 * ```php
 * use RichPHPTests\Attributes; // import the attributes namespace
 * use RichPHPTests\TestCase;

 * #[Attributes\Skip] // skip this class
 * class SomeTest extends TestCase
 * {
 *     #[Attributes\Skip] // skip this test
 *     public function testSomeFunction(): void
 *     {
 *         // ...
 *     }
 * }
 * ```
 */
#[Attribute(Attribute::TARGET_METHOD | Attribute::TARGET_CLASS)]
class Skip
{
    public function __construct() {}
}
