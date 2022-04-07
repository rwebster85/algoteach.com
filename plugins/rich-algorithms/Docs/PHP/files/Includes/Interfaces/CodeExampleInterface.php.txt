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

interface CodeExampleInterface
{
    /**
     * Returns the language for the code example.
     * 
     * @return string
     */
    public function getLanguage(): string;

    /**
     * Returns the language for the code example suitable for outputting.
     * 
     * @return string
     */
    public function getLanguageFormatted(): string;

    /**
     * Returns the version number of the programming language used for the code example.
     * 
     * @return string
     */
    public function getLanguageVersion(): string;

    /**
     * Returns the additional info attached to this code snippet.
     * 
     * @return string
     */
    public function getInfo(): string;

    /**
     * Returns the code for this code example.
     * 
     * @return string
     */
    public function getCode(): string;
}
