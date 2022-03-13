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

namespace RichWeb\Algorithms\Events;

use RichWeb\Algorithms\Interfaces\EventCreatorInterface;

use function do_action;

class WPEventCreator implements EventCreatorInterface
{
    /**
     * Creates a new event that other objects can subscribe to using the WordPress Plugin API. Essentially a wrapper for the `do_action()` WP function.
     *
     * Example usage:
     * 
     * ```php
     * $creator = new WPEventCreator();
     * // Without any arguments
     * $creator->create('event_name');
     * // With arguments (any number of arguments are accepted)
     * $creator->create('event_name', $arg1, $arg2);
     * ```
     * 
     * Objects or functions can subscribe to an event using the WPEventSubscriber object.
     * 
     * @uses \do_action() WP Function
     * 
     * @see https://developer.wordpress.org/plugins/hooks/ WordPress hooks
     * @see WPEventSubscriber                              Event subscriber class.
     */
    final function create(string $event, mixed ...$args): void
    {
        do_action($event, $args);
    }
}
