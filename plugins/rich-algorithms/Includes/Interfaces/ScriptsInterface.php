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

interface ScriptsInterface
{
    /**
     * Enqueues the scripts and styles for admin pages. Hooked from 'admin_enqueue_scripts' action.
     * 
     * @see https://developer.wordpress.org/reference/hooks/admin_enqueue_scripts/ WP Action
     * 
     * @return void
     */
    public function enqueueAdminScripts(string $hook): void;

    /**
     * Enqueues the scripts and styles for the frontend. Hooked from 'wp_enqueue_scripts' action.
     * 
     * @see https://developer.wordpress.org/reference/hooks/wp_enqueue_scripts/ WP Action
     * 
     * @return void
     */
    public function enqueueFrontendScripts(): void;
}
