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

interface AlgorithmInterface
{
    /**
     * Loads the scripts required for the algorithm.
     * 
     * @return void
     */
    public function loadScripts(): void;

    /**
     * Hooked into from the WP hook 'the_content'. Appends all the code examples for an Algorithm to post content.
     * 
     * @see https://developer.wordpress.org/reference/hooks/the_content/ WP action
     * 
     * @param string $content
     * 
     * @return string
     */
    public function appendExamplesToContent(string $content): string;

    /**
     * Returns an array of \RichWeb\Algorithms\CodeExample objects for a post.
     * 
     * @return array
     */
    public function getCodeExamples(): array;
}
