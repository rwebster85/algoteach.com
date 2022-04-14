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

namespace RichPHPTests\Interfaces;

interface ProjectInterface
{
    /**
     * Builds the project information.
     * 
     * @return void
     */
    public function buildProject(): void;

    /**
     * Returns the full path to the main project directory.
     * 
     * @return string
     */
    public function getMainDirectory(): string;

    /**
     * Returns the name of this project.
     * 
     * @return string
     */
    public function getName(): string;

    /**
     * Returns the version of this project.
     * 
     * @return string
     */
    public function getVersion(): string;

    /**
     * Returns an array of the requirements needed for this project to run.
     * 
     * @return array
     */
    public function getRequirements(): array;

    /**
     * Returns the sources used by the Autoloader.
     * 
     * @return array
     */
    public function getAutoloaderSources(): array;

    /**
     * Returns the sources used by the Fileloader.
     * 
     * @return array
     */
    public function getFileSources(): array;
}
