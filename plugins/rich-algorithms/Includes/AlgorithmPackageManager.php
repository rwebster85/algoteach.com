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
use RichWeb\Algorithms\Interfaces\AlgorithmPackageLoaderInterface;
use RichWeb\Algorithms\Interfaces\AlgorithmPackageManagerInterface;
use RichWeb\Algorithms\Interfaces\SyntaxHighlighterInterface;
use RichWeb\Algorithms\Traits\Formatting\FilePaths;

use const DIRECTORY_SEPARATOR;

final class AlgorithmPackageManager implements AlgorithmPackageManagerInterface
{
    use FilePaths;

    private string $package_folder;

    private AlgorithmPackageLoaderInterface $loader;

    /**
     * @var array<string, AlgorithmPackage>
     */
    private array $packages;

    public function __construct(
        private string $main_directory,
        private SyntaxHighlighterInterface $syntax
    ) {
        $this->package_folder = $this->formatSlashes($main_directory . '/Algorithms/');

        $this->parsePackages();

        $this->loader = new AlgorithmPackageLoader($this->packages, $this->syntax);
        $this->loader->run();
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
}
