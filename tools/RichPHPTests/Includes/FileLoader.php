<?php

declare(strict_types=1);

namespace RichPHPTests;

final class FileLoader
{
    private array $files = [];

    public function __construct(array $files)
    {
        foreach ($files as $file) {
            $this->files[] = $file;
        }
    }

    public function loadFiles(): void
    {
        foreach ($this->files as $file) {
            $this->requireFile($file);
        }
    }

    private function requireFile($file): void
    {
        if (file_exists($file)) {
            require_once $file;
        }
    }
}
