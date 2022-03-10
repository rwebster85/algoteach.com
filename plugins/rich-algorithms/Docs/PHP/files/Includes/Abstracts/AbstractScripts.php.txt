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

namespace RichWeb\Algorithms\Abstracts;

use RichWeb\Algorithms\Interfaces\HasRunnerInterface;
use RichWeb\Algorithms\Interfaces\ScriptsInterface;

abstract class AbstractScripts implements ScriptsInterface, HasRunnerInterface
{
    abstract public function enqueueAdminScripts(string $hook): void;
    abstract public function enqueueFrontendScripts(): void;

    public function run(): void
    {
        $this->actions();
    }

    /**
     * The action hooks to set up on initialisation.
     */
    private function actions(): void
    {
        add_action('admin_enqueue_scripts', [$this, 'enqueueAdminScripts'], 10, 1);
        add_action('wp_enqueue_scripts', [$this, 'enqueueFrontendScripts']);
    }
}
