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
     * Creates a new event that other objects can subscribe to.
     * 
     * @param string $event   The name of the event to subscribe to.
     * @param mixed  ...$args Variadic array of possible arguments to include with the event.
     * 
     * @return void
     */
    public function create(string $event, mixed ...$args): void;

    /**
     * Creates a new filter that other objects can subscribe to and intercept.
     * 
     * @param string $filter  The name of the filter to create.
     * @param mixed  $value   The value being filtered.
     * @param mixed  ...$args Variadic array of possible arguments to include with the filter.
     * 
     * @return mixed
     */
    public function filter(string $filter, mixed $value, mixed ...$args): mixed;
}
