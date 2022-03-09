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

namespace RichWeb\Algorithms\Traits\Formatting;

trait FilePaths
{
    /**
     * Normalises forward and/or backward slashes to the system directory separator.
     * 
     * @param string $path
     * 
     * @uses \str_replace()
     * 
     * @return string The normalised path
     */
    protected function formatSlashes(string $path): string
    {
        return(str_replace(["\\", "/"], DIRECTORY_SEPARATOR, $path));
    }
}
