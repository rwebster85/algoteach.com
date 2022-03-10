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

interface AlgorithmPackageLoaderInterface
{
    /**
     * Loads the package for the current post.
     * 
     * @see https://developer.wordpress.org/reference/hooks/template_redirect/ WP Action
     * 
     * @return void
     */
    public function loadPackageForPost(): void;

    /**
     * Returns all the algorithm packages found.
     * 
     * @return array<string, AlgorithmPackage>
     */
    public function getPackages(): array;

    /**
     * Loads the given package.
     * 
     * @param string $name The fully qualified class name.
     * @param int $post_id
     * 
     * @return void
     */
    public function loadPackage(string $name, int $post_id): void;
}
