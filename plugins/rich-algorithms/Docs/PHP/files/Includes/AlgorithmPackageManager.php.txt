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

namespace RichWeb\Algorithms;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RichWeb\Algorithms\AlgorithmPackage;
use RichWeb\Algorithms\Traits\Formatting\FilePaths;

use const DIRECTORY_SEPARATOR;

final class AlgorithmPackageManager
{
    use FilePaths;

    private string $package_folder;

    /**
     * @var array<string, AlgorithmPackage>
     */
    private array $packages;

    public function __construct(string $main_directory)
    {
        $this->package_folder = $this->formatSlashes($main_directory . '/Algorithms/');

        $this->parsePackages();

        $this->loadPackage('Example Algorithm');
    }

    public function getPackages(): array
    {
        return $this->packages;
    }

    private function parsePackages(): void
    {
        $packages = [];

        $folder = new RecursiveDirectoryIterator(
            $this->package_folder,
            RecursiveDirectoryIterator::SKIP_DOTS
        );
        
        $files = new RecursiveIteratorIterator($folder);

        /** @var \SplFileInfo $file */
        foreach($files as $file) {
            if ($file->getFilename() == 'algorithm.json') {
                $algorithm = new AlgorithmPackage(
                    $file->getPath() . DIRECTORY_SEPARATOR . $file->getFileName()
                );
                $name = $algorithm->getQualifiedClassName();
                $packages[$name] = $algorithm;
            }
        }

        $this->packages = $packages;
    }

    public function loadPackage(string $name): void
    {
        if (array_key_exists($name, $this->packages)) {
            /** @var AlgorithmPackage $package */
            $package = $this->packages[$name];
            $path = $package->getPath();
            if (file_exists($path)) {
                require_once $path;
                $class = $package->getQualifiedClassName();
                (new $class());
            }
        }
    }
}
