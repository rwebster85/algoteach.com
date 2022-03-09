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

namespace RichWeb\Algorithms\Setup;

use RichWeb\Algorithms\Abstracts\AbstractScripts;

class PrismSyntaxtHighlighterScripts extends AbstractScripts
{
    public function __construct() {}

    public function enqueueAdminScripts(string $hook): void {}

    public function enqueueFrontendScripts(): void
    {
        $assets = plugins_url('/Assets/', RICH_ALGO_FILE);

        $timestamp = time();

        wp_register_script(
            'rich-algo-prism-script',
            $assets . 'JS/prism.js',
            ['jquery'],
            $timestamp,
            true
        );
        wp_enqueue_script('rich-algo-prism-script');
        
        wp_register_style('rich-algo-prism-style', $assets . 'CSS/prism.css', [], $timestamp);
        wp_enqueue_style('rich-algo-prism-style');
    }
}
