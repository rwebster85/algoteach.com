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

namespace RichWeb\Algorithms\Packages;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RichWeb\Algorithms\Interfaces\AlgorithmPackageManagerInterface;
use RichWeb\Algorithms\Packages\AlgorithmPackage;

use const DIRECTORY_SEPARATOR as SEP;

/**
 * Finds any algorithm packages present and creates an array of those packages, represented as AlgorithmPackage objects.
 */
final class AlgorithmPackageManager implements AlgorithmPackageManagerInterface
{
    /**
     * A key/value pair of AlgorithmPackage objects. Key is the fully qualified package class name, value is the package object.
     * 
     * @var array<string, AlgorithmPackage>
     */
    private array $packages;

    /**
     * Creates a new package manager.
     * 
     * @param string $package_folder The folder where algorithm packages are stored.
     */
    public function __construct(
        private string $package_folder
    ) {
        $this->parsePackages();
    }

    public function getPackages(): array
    {
        return $this->packages;
    }

    /**
     * Iterates through the package folder to discover available packages, creates a new AlgorithmPackage object for each one and stores them in $packages.
     * 
     * @uses AlgorithmPackage
     * @uses AlgorithmPackageManager::$packages
     * @uses \RecursiveDirectoryIterator
     * @uses \RecursiveIteratorIterator
     * @uses \SplFileInfo
     * 
     * @return void
     */
    private function parsePackages(): void
    {
        $packages = [];

        if (file_exists($this->package_folder)) {
            $files = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator(
                    $this->package_folder,
                    RecursiveDirectoryIterator::SKIP_DOTS
                )
            );
    
            /** @var \SplFileInfo $file */
            foreach($files as $file) {
                if ($file->getFilename() == 'algorithm.json') {
                    $algorithm = new AlgorithmPackage(
                        $file->getPath() . SEP . $file->getFileName()
                    );
                    $name = $algorithm->getQualifiedClassName();
                    $packages[$name] = $algorithm;
                }
            }
        }

        $this->packages = $packages;
    }
}
