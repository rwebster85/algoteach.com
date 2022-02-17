<?php

declare(strict_types=1);

namespace RichPHPTests;

use function file_exists;

final class FileLoader
{
    /**
     * Array of file path strings for loading.
     * 
     * @var string[]
     */
    private array $files = [];

    /**
     * Accepts an array of strings as file paths to load.
     * 
     * @param string[] $files
     */
    public function __construct(string ...$files)
    {
        $this->files = $files;
    }

    /**
     * Iterates through $files and passes each to requireFile().
     * 
     * @uses FileLoader::$files
     * @uses FileLoader::requireFile()
     * 
     * @return void
     */
    public function loadFiles(): void
    {
        foreach ($this->files as $file) {
            $this->requireFile($file);
        }
    }

    /**
     * Checks if a file exists then requires it.
     * 
     * @param string $file
     * 
     * @uses \file_exists
     * 
     * @return void
     */
    private function requireFile(string $file): void
    {
        if (file_exists($file)) {
            require_once $file;
        }
    }
}
