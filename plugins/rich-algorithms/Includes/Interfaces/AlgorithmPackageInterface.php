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

namespace RichWeb\Algorithms\Interfaces;

interface AlgorithmPackageInterface
{
    /**
     * Returns the path to the algorithm config file.
     * 
     * @return string
     */
    public function getConfigPath(): string;

    /**
     * Returns an array of JavaScript files from the config file required by the algorithm.
     * 
     * @return array
     */
    public function getScripts(): array;

    /**
     * Returns an array of CSS files from the config file required by the algorithm.
     * 
     * @return array
     */
    public function getStyles(): array;

    /**
     * Returns the unqualified class name of the package.
     * 
     * @return string
     */
    public function getClass(): string;

    /**
     * Returns the namespace of the class.
     * 
     * @return string
     */
    public function getNamespace(): string;

    /**
     * Returns the package name.
     * 
     * @return string
     */
    public function getName(): string;

    /**
     * Returns the package version.
     * 
     * @return string
     */
    public function getVersion(): string;

    /**
     * Returns the full path to the package main class file.
     * 
     * @return string
     */
    public function getPath(): string;

    /**
     * Returns the full class name including the namespace.
     * 
     * @return string
     */
    public function getQualifiedClassName(): string;
}
