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

interface EventSubscriberInterface
{
    /**
     * Registers an object for event callback.
     * 
     * @param string        $event    The event name to subscribe to.
     * @param array|string  $callback The callback method to be called by the event.
     * @param int           $priority The priority to register for.
     * @param int           $args     The number of arguments to accept in the callback method.
     * 
     * @return void
     */
    public function subscribe(string $event, array|string $callback, int $priority = 10, int $args = 1): void;
}
