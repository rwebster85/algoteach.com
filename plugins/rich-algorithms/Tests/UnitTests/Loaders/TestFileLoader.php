<?php

namespace RichAlgoUnitTests\Loaders;

use RichPHPTests\TestCase;
use RichWeb\Algorithms\Loaders\FileLoader;

use const DIRECTORY_SEPARATOR as SEP;

class TestFileLoader extends TestCase
{
    public function testFileLoaderLoadsFile(): void
    {
        $files = [__DIR__ . SEP . 'MockFileLoaderClassFile.php'];
        (new FileLoader(...$files))->loadFiles();
        $exists = class_exists(__NAMESPACE__ . '\MockFileLoaderClassFile', false);
        test($exists)->isTrue();
    }

    /**
     * The FileLoader class should not raise any errors for files that don't exist.
     * 
     * @return void
     */
    public function testFileLoaderFileNotExists(): void
    {
        $files = [__DIR__ . SEP . 'DoesNotExist.php'];
        (new FileLoader(...$files))->loadFiles();
        $exists = class_exists(__NAMESPACE__ . '\DoesNotExist', false);
        test($exists)->isFalse();
    }
}
