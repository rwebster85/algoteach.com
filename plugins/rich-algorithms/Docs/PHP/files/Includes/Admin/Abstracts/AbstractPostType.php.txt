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

namespace RichWeb\Algorithms\Admin\Abstracts;

use RichWeb\Algorithms\Admin\Interfaces\PostTypeInterface;
use RichWeb\Algorithms\Interfaces\HasRunnerInterface;

abstract class AbstractPostType implements PostTypeInterface, HasRunnerInterface
{
    /**
     * Runs the class init functions not handled during construction.
     */
    public function run(): void
    {
        $this->actions();
    }

    /**
     * Called by `run()` and is used to set up all the actions for the post type.
     * 
     * @return void
     */
    abstract protected function actions(): void;

    /**
     * Register the post type. Called via WP action.
     * 
     * @return void
     */
    abstract public function register(): void;
}
