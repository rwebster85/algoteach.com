<?php

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
#[Attribute]
class Skip
{
    public function __construct() {}
}
