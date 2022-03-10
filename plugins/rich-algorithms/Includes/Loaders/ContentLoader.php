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

namespace RichWeb\Algorithms\Loaders;

use RichWeb\Algorithms\Interfaces\FileLoaderInterface;
use function file_exists;

/**
 * Content loader includes/requires Content PHP files (views).
 * 
 * Accepts a string path to a content file.
 * 
 * Example usage:
 * 
 * ```php
 * $files = [
 *     'File1.php',
 *     'Files2.php'
 * ];
 * 
 * $file_loader = new FileLoader(...$files);
 * $file_loader->loadFiles();
 * ```
 */
final class ContentLoader
{
    /**
     * The path to a content file to load.
     * 
     * @param string Filepath
     * @param bool Whether to use require or include
     */
    public function __construct(
        private string $path,
        private bool $require = false
    ) {}

    /**
     * Iterates through $files and passes each to requireFile().
     * 
     * @uses FileLoader::$files
     * @uses FileLoader::requireFile()
     * 
     * @return void
     */
    public function loadFile(): void
    {
        if (file_exists($this->path)) {
            if ($this->require) {
                require_once $this->path;
            } else {
                include $this->path;
            }
        }
    }
}
