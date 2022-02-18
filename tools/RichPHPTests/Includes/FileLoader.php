<?php

declare(strict_types=1);

namespace RichPHPTests;

use function file_exists;

final class FileLoader
{
    /**
     * The files to be loaded.
     * 
     * @var string[]
     */
    private array $files;

    /**
     * Accepts an array of strings as file paths to load.
     * 
     * @param string[] $filepaths
     * 
     * @return void
     */
    public function __construct(string ...$filepaths)
    {
        $this->files = $filepaths;
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
