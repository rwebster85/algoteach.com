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

use const RichWeb\Algorithms\PLUGIN_FILE;

/**
 * Loads the JS and CSS files needed by the plugin.
 */
class Scripts extends AbstractScripts
{
    public function __construct() {}

    public function enqueueAdminScripts(string $hook): void
    {
        // Add the current timestamp as a file version number
        // Prevents browser being able to cache the file
        $timestamp = time();

        $admin_assets = plugins_url('/Assets/Admin/', PLUGIN_FILE);

        // Admin CSS files, register first then enqueue
        wp_register_style('rich-algo-admin', $admin_assets . 'CSS/rich-algo-admin.css', [], $timestamp);
        wp_enqueue_style('rich-algo-admin');

        global $post;
        if ($hook == 'post-new.php' || $hook == 'post.php') {
            if ($post->post_type === 'richweb_algorithm') {
                wp_register_script('rich-algo-example-admin', $admin_assets . 'JS/rich-algo-example-admin.js', ['jquery-ui-sortable', 'jquery'], $timestamp, true);
                wp_localize_script('rich-algo-example-admin', 'rich_algo_example_params', [
                    'rich_algo_example_add_new_nonce' => wp_create_nonce('rich-algo-example-add-new'),
                    'ajax_url' => admin_url('admin-ajax.php')
                ]);
                wp_enqueue_script('rich-algo-example-admin');
            }
        }
    }

    public function enqueueFrontendScripts(): void
    {
        $assets = plugins_url('/Assets/', PLUGIN_FILE);

        $timestamp = time();

        wp_register_script('rich-algo-script', $assets . 'JS/rich-algo.js', ['jquery'], $timestamp, true);
        wp_enqueue_script('rich-algo-script');

        wp_register_style('rich-algo-style', $assets . 'CSS/style.css', [], $timestamp);
        wp_enqueue_style('rich-algo-style');
    }
}
