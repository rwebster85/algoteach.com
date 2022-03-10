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

namespace RichWeb\Algorithms\Traits\Posts;

trait AlgorithmChecker
{
    /**
     * Returns true if the current post is a singular algorithm.
     *
     * @uses \is_singular()
     * 
     * @return bool
     */
    protected function isSingleAlgorithm(): bool
    {
        return is_singular('richweb_algorithm');
    }
}
