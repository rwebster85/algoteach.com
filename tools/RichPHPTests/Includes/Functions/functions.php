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

use RichPHPTests\Test;

if (!function_exists('test')) {
    /**
     * Creates a new test. Called from test functions in test classes.
     * 
     * @param mixed $value
     * 
     * @return Test
     */
    function test(mixed $value = null): Test
    {
        return new Test($value);
    }
}
