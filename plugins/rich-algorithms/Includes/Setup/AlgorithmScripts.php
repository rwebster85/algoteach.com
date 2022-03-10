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
use RichWeb\Algorithms\Interfaces\AlgorithmPackageInterface;

use const RichWeb\Algorithms\PLUGIN_FILE;

/**
 * Loads the JS and CSS files needed by the algorithm.
 */
class AlgorithmScripts extends AbstractScripts
{
    public function __construct(
        private AlgorithmPackageInterface $package
    ) {
        
    }

    public function enqueueAdminScripts(string $hook): void {}

    public function enqueueFrontendScripts(): void
    {
        $algorithm_path = $this->package->getConfigPath();

        $scripts = plugins_url('/Assets/JS/', $algorithm_path);
        $styles  = plugins_url('/Assets/CSS/', $algorithm_path);

        return;

        $config_path = $this->package->getConfigPath();

        $assets = plugins_url('/Assets/', PLUGIN_FILE);

        $timestamp = time();

        wp_register_script('rich-algo-script', $assets . 'JS/rich-algo.js', ['jquery'], $timestamp, true);
        wp_enqueue_script('rich-algo-script');

        wp_register_style('rich-algo-style', $assets . 'CSS/style.css', [], $timestamp);
        wp_enqueue_style('rich-algo-style');
    }
}
