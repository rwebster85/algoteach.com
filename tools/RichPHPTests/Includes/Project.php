<?php

/*
 * This file is part of RichPHPTests.
 *
 * Copyright (c) Richard Webster
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace RichPHPTests;

use RichPHPTests\Interfaces\ProjectInterface;

use const DIRECTORY_SEPARATOR as SEP;

/**
 * An object that stores information about the current project such as name, version number, and autoload/manual directories.
 * 
 * Also includes details relating to any project requirements.
 * 
 * Information is parsed from the `project.json` file in the project root directory.
 * 
 * Example usage from the root directory:
 * ```php
 * $path = __DIR__ . DIRECTORY_SEPARATOR;
 * $project = new Project($path . 'project.json', __DIR__);
 * $project->buildProject();
 * ```
 * 
 * Eample `project.json` file:
 * ```json
 * {
 *     "name": "RichPHPTests",
 *     "version": "1.0.0",
 *     "required_php": "8.0.0",
 *     "sources": {
 *         "autoload": {
 *             "RichPHPTests": "Includes"
 *         },
 *         "files": [
 *             "Includes/Functions/functions.php"
 *         ]
 *     },
 *     "requirements" : [
 *         {
 *             "type_id"   : "php_min_ver",
 *             "type_name" : "Minimum PHP Version",
 *             "name"      : "Version 8.0.0",
 *             "url"       : "https://www.php.net/manual/en/migration74.php",
 *             "value"     : "8.0.0"
 *         }
 *     ],
 *     "richpybuild": {
 *         "exclude_files" : [],
 *         "exclude_extensions" : [],
 *         "exclude_folders" : []
 *     }
 * }
 * ```
 * 
 * Compatible with the included custom RichPyBuild tool for creating project archives, and the Autoloader and FileLoader classes.
 * 
 * Example usage with the Autoloader:
 * ```php
 * require_once 'Path\To\Autoloader.php';
 * (new Autoloader($project->getAutoloaderSources()))->register();
 * ```
 * 
 * Example usage with the FileLoader:
 * ```php
 * (new FileLoader(...$project->getFileSources()))->loadFiles();
 * ```
 */
final class Project implements ProjectInterface
{
    private array $config = [];

    private array $autoload_sources = [];

    private array $file_sources = [];

    private string $name;

    private string $version;

    private array $requirements;

    public function __construct(
        private string $config_path,
        private string $main_directory
    ) {}

    public function buildProject(): void
    {
        if (file_exists($this->config_path)) {
            $this->config = json_decode(file_get_contents($this->config_path), true);
            $this->setName();
            $this->setVersion();
            $this->setRequirements();
            $this->setAutoloaderSources();
            $this->setFileSources();
        }
    }

    public function getMainDirectory(): string
    {
        return $this->main_directory;
    }

    private function setName(): void
    {
        $this->name = (string) ($this->config['name'] ?? '');
    }

    public function getName(): string
    {
        return $this->name;
    }

    private function setVersion(): void
    {
        $this->version = (string) ($this->config['version'] ?? '');
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    private function setRequirements(): void
    {
        $this->requirements = (array) ($this->config['requirements'] ?? []);
    }

    public function getRequirements(): array
    {
        return $this->requirements;
    }

    private function setAutoloaderSources(): void
    {
        $autoload = [];

        if (
            isset($this->config['sources'])
            && isset($this->config['sources']['autoload'])
        ) {
            $autoload = (array) $this->config['sources']['autoload'];
        }

        foreach ($autoload as $namespace => $path) {
            $this->autoload_sources[$namespace] = $this->main_directory . SEP . $path;
        }
    }

    private function setFileSources(): void
    {
        $files = [];
        
        if (
            isset($this->config['sources'])
            && isset($this->config['sources']['files'])
        ) {
            $files = (array) $this->config['sources']['files'];
        }

        foreach ($files as $file) {
            $this->file_sources[] = $this->formatSlashes($this->main_directory . SEP . $file);
        }
    }

    public function getAutoloaderSources(): array
    {
        return $this->autoload_sources;
    }

    public function getFileSources(): array
    {
        return $this->file_sources;
    }

    /**
     * Normalises forward and/or backward slashes to the system directory separator.
     * 
     * @param string $path
     * 
     * @return string The normalised path
     */
    private function formatSlashes(string $path): string
    {
        return(str_replace(["\\", "/"], SEP, $path));
    }
}
