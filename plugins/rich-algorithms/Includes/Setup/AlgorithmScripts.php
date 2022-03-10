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
use RichWeb\Algorithms\Traits\Formatting;

/**
 * Loads the JS and CSS files needed by the algorithm.
 */
class AlgorithmScripts extends AbstractScripts
{
    use Formatting\FilePaths;
    use Formatting\Strings;

    public function __construct(
        private AlgorithmPackageInterface $package
    ) {}

    public function enqueueAdminScripts(string $hook): void {}

    public function enqueueFrontendScripts(): void
    {
        $timestamp = time();

        $algorithm_path = plugin_dir_path($this->package->getConfigPath());

        $scripts = $this->package->getScripts();

        if (!empty($scripts)) {
            $scripts_path = $this->formatSlashes($algorithm_path . 'Assets/JS/');
            $scripts_url  = plugins_url('JS/', $scripts_path);

            foreach ($scripts as $script) {
                $script_path = $this->formatSlashes($scripts_path . $script);
                if (file_exists($script_path)) {
                    $script_url = $scripts_url . $script;
                    $class = $this->package->getClass();
                    $file = pathinfo($script, PATHINFO_FILENAME);
                    $script_name = $this->escAttr(strtolower($class . '-' . $file .'-' . 'script'));
                    wp_enqueue_script($script_name, $script_url, ['jquery'], $timestamp, true);
                }
            }
        }

        $styles = $this->package->getStyles();

        if (!empty($styles)) {
            $styles_path = $this->formatSlashes($algorithm_path . 'Assets/CSS/');
            $styles_url  = plugins_url('CSS/', $styles_path);

            foreach ($styles as $style) {
                $style_path = $this->formatSlashes($styles_path . $style);
                if (file_exists($style_path)) {
                    $style_url = $styles_url . $style;
                    $class = $this->package->getClass();
                    $file = pathinfo($style, PATHINFO_FILENAME);
                    $style_name = $this->escAttr(strtolower($class . '-' . $file .'-' . 'style'));
                    wp_enqueue_style($style_name, $style_url, [], $timestamp);
                }
            }
        }
    }
}
