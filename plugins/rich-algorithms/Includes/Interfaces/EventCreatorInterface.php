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

interface EventCreatorInterface
{
    /**
     * Creates a new event that other objects can subscribe to with the WordPress Plugin API.
     * 
     * @param string $event
     * @param array ...$args
     * 
     * @return void
     */
    public function create(string $event, mixed ...$args): void;
}
