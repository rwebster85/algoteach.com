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

namespace RichWeb\Algorithms\Algorithm;

use RichWeb\Algorithms\Abstracts\AbstractAlgorithm;

use const RichWeb\Algorithms\PLUGIN_FILE;

final class Dijkstra extends AbstractAlgorithm
{
    protected function load(): void
    {
        wp_enqueue_script('rich-algo-go-js', 'https://gojs.net/latest/release/go-debug.js', ['jquery'], '2.2.5', true);
    }

    public function demo(?string $content = ''): string
    {
        ob_start();

        echo '<div class="">';
        echo '<div id="sample"><div id="rich-algo-shortest-path-example" style="border: solid 1px black; background: white; width: 100%; height: 500px"></div></div>';
        echo '</div>';

        echo '<hr>';

        $before = ob_get_clean();
        return $before . $content;
    }
}
