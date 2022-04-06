<?php

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
