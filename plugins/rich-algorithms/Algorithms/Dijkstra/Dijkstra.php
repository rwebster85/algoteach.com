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
use RichWeb\Algorithms\Loaders\ContentLoader;

use const RichWeb\Algorithms\PLUGIN_FILE;

final class Dijkstra extends AbstractAlgorithm
{
    protected function load(): void
    {
        //
    }

    public function demo(?string $content = ''): string
    {
        $path = __DIR__ . $this->formatSlashes('\DemoContent.php');
        $loader = new ContentLoader($path, $this);
        
        ob_start();
        $loader->loadFile();
        return ob_get_clean() . $content;
    }
}
