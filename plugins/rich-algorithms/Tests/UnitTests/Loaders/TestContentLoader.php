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

namespace RichAlgoUnitTests\Loaders;

use RichPHPTests\TestCase;
use RichWeb\Algorithms\Loaders\ContentLoader;

use const DIRECTORY_SEPARATOR as SEP;

class TestContentLoader extends TestCase
{
    public function testContentLoaderLoadsFile(): void
    {
        $path = __DIR__ . SEP . 'MockContentFile.php';

        ob_start();
        $loader = new ContentLoader($path, $this);
        $loader->loadFile();
        $content = ob_get_clean();

        test($content)->stringMatches('Content was loaded');
    }
}
