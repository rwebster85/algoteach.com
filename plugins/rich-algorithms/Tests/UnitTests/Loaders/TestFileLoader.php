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
use RichWeb\Algorithms\Loaders\FileLoader;
use stdClass;

use const DIRECTORY_SEPARATOR as SEP;

class TestFileLoader extends TestCase
{
    public function testLoadsFile(): void
    {
        $files = [__DIR__ . SEP . 'MockFileLoaderClassFile.php'];
        (new FileLoader(...$files))->loadFiles();
        $exists = class_exists(
            __NAMESPACE__ . '\MockFileLoaderClassFile',
            false
        );
        test($exists)->isTrue();
    }

    /**
     * The FileLoader class should not raise any errors for files that don't exist.
     * 
     * @return void
     */
    public function testFileNotExists(): void
    {
        $files = [__DIR__ . SEP . 'DoesNotExist.php'];
        (new FileLoader(...$files))->loadFiles();
        $exists = class_exists(
            __NAMESPACE__ . '\DoesNotExist',
            false
        );
        test($exists)->isFalse();
    }

    public function testRaisesErrorIncorrectTypeSingle(): void
    {
        $error = false;

        try {
            $loader = new FileLoader(new stdClass());
        } catch (\Throwable $th) {
            $error = true;
        }
        
        test($error)->isTrue();
    }

    public function testRaisesErrorIncorrectTypeMultiple(): void
    {
        $error = false;

        try {
            $files = [new stdClass(), new stdClass()];
            $loader = new FileLoader(...$files);
        } catch (\Throwable $th) {
            $error = true;
        }
        
        test($error)->isTrue();
    }
}
