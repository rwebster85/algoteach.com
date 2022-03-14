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

namespace RichWeb\Algorithms\Setup\Scripts;

use RichWeb\Algorithms\Interfaces\HasRunnerInterface;
use RichWeb\Algorithms\Interfaces\ScriptsInterface;

class FrontendScriptLoader
{
    public function run(): void
    {
        $this->actions();
    }

    /**
     * @param object $caller
     * @param string $callback
     * @param int $priority
     * @param int $args
     * 
     * @uses \add_action() WP Function
     * 
     * @return void
     */
    final public function register(string $action, object $caller, string $callback, int $priority = 10, int $args = 1): void
    {
        add_action($action, [$caller, $callback], $priority, $args);
    }

    final public function load(Script $script): void
    {
        wp_enqueue_script(
            $script->handle(),
            $script->src(),
            $script->deps(),
            $script->vers(),
            $script->footer()
        );
    }
}
