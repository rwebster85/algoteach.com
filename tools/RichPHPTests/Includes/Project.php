<?php

declare(strict_types=1);

namespace RichPHPTests;

use const DIRECTORY_SEPARATOR;

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
 *     "pybuild": {
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
final class Project
{
    private array $config = [];

    private array $autoload_sources = [];

    private array $file_sources = [];

    private string $name;

    private string $version;

    private array $requirements;

    private string $sep = DIRECTORY_SEPARATOR;

    /**
     * Builds a new Project containing the paths for files and the autoloader. Also assigns project specific details such as name and version number.
     * 
     * @param $config_path The path to the project.json configuration file
     * @param $main_directory The full path to the main directory of the project
     */
    public function __construct(
        private string $config_path,
        private string $main_directory
    ) {
        if (file_exists($this->config_path)) {
            $this->config = $this->parseConfig();
            $this->setName();
            $this->setVersion();
            $this->setRequirements();
            $this->setAutoloaderSources();
            $this->setFileSources();
        }
    }

    private function parseConfig(): array
    {
        return json_decode(file_get_contents($this->config_path), true);
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
            $this->autoload_sources[$namespace] = $this->main_directory . $this->sep . $path;
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
            $this->file_sources[] = $this->formatSlashes($this->main_directory . $this->sep . $file);
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
        return(str_replace(["\\", "/"], $this->sep, $path));
    }
}
