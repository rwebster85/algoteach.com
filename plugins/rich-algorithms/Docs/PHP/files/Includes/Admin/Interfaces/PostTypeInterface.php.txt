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

namespace RichWeb\Algorithms\Admin\Interfaces;

interface PostTypeInterface
{
    /**
     * Called via hooks to register this custom post type.
     * 
     * @return void
     */
    public function register(): void;
}
