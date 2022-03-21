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

use RichWeb\Algorithms\Interfaces\ProjectInterface;

interface SingletonPluginInterface
{
    /**
     * Main Class Instance.
     *
     * Ensures only one instance of this class is loaded or can be loaded.
     */
    public static function instance(?ProjectInterface $project);
}
