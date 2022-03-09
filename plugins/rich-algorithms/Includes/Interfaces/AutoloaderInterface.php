<?php

/*
 * This file is part of Rich Algorithms.
 *
 * Copyright (c) Richard Webster
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/*
 * Autoloader class adapted from PHP Framework Interop Group, 2016
 */

declare(strict_types=1);

namespace RichWeb\Algorithms\Interfaces;

interface AutoloaderInterface
{
    /**
     * Register loader with SPL autoloader stack.
     *
     * @return void
     */
    public function register(): void;

    /**
     * Adds a base directory for a namespace prefix.
     *
     * @param string $prefix The namespace prefix.
     * @param string $base_dir A base directory for class files in the
     * namespace.
     * @param bool $prepend If true, prepend the base directory to the stack
     * instead of appending it; this causes it to be searched first rather
     * than last.
     * 
     * @return void
     */
    public function addNamespace($prefix, $base_dir, $prepend = false);

    /**
     * Loads the class file for a given class name.
     *
     * @param string $class The fully-qualified class name.
     * 
     * @return string|bool The mapped file name on success, or boolean false on failure.
     */
    public function loadClass($class): string|bool;
}
//end of adapted code
