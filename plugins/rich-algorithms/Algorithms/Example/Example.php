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

namespace RichWeb\Algorithms\Packages;

use RichWeb\Algorithms\Abstracts\AbstractAlgorithm;

use const RichWeb\Algorithms\PLUGIN_FILE;

final class Example extends AbstractAlgorithm
{
    protected function load(): void
    {
        $this->loadAssets();
    }

    private function loadAssets(): void
    {
        //add_action('wp_enqueue_scripts', [$this, 'loadScripts']);
    }

    public function loadScriptsss(): void
    {
        //$path = dirname(__FILE__) . $this->formatSlashes('\Assets\JS\example.js');

        $assets = plugins_url('/Algorithms/Example/Assets/', PLUGIN_FILE);

        $timestamp = time();

        wp_register_script('rich-algo-example-script', $assets . '/JS/example.js', ['jquery'], $timestamp, true);
        wp_enqueue_script('rich-algo-example-script');
    }
}
