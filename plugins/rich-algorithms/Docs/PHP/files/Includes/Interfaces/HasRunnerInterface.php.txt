<?php

/*
 * This file is part of Rich Algorithms.
 *
 * Copyright (c) Richard Webster
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace RichWeb\Algorithms\Interfaces;

interface HasRunnerInterface
{
    /**
     * Runs the class init functions not handled during construction.
     * 
     * @return void
     */
    public function run(): void;
}
