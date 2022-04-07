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
 * The Run attribute can be applied to test classes or methods to have them exclusively included in the test run.
 * 
 * If applied to a method, that class must also have the attribute.
 * 
 * Example Usage:
 * ```php
 * use RichPHPTests\Attributes; // import the attributes namespace
 * use RichPHPTests\TestCase;

 * #[Attributes\Run] // include this class
 * class SomeTest extends TestCase
 * {
 *     #[Attributes\Run] // include this test
 *     public function testSomeFunction(): void
 *     {
 *         // ...
 *     }
 * }
 * ```
 */
#[Attribute(Attribute::TARGET_METHOD | Attribute::TARGET_CLASS)]
class Run
{
    public function __construct() {}
}
