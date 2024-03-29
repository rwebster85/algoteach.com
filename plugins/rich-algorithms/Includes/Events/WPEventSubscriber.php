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

use RichWeb\Algorithms\Interfaces\EventSubscriberInterface;

use function add_filter;

class WPEventSubscriber implements EventSubscriberInterface
{
    /**
     * Registers an object for event callback with the WordPress Plugin API. Essentially a wrapper for the `add_filter()` WP function.
     * 
     * If callback is an array, it expects an object and a method name string.
     * 
     * Example usage:
     * 
     * ```php
     * $subscriber = new WPEventSubscriber();
     * $object     = new SomeClass();
     * // Using an object
     * // 'methodName' should be a public method on the $object
     * $subscriber->subscribe('event_name', [$object, 'methodName'], 10, 1);
     * // Using a function
     * $subscriber->subscribe('event_name', 'someFunction', 10, 1);
     * 
     * // Object callback
     * class SomeClass
     * {
     *     // This method is called when the event 'event_name' is triggered
     *     public function methodName(mixed $some_arg): void
     *     {
     *         // code...
     *     }
     * }
     * 
     * // Function callback
     * // This function is called when the event 'event_name' is triggered
     * function someFunction(mixed $some_arg): void
     * {
     *     // code..
     * }
     * ```
     * 
     * Objects or functions can create an event using the WPEventCreator object.
     * 
     * @uses \add_filter() WP Function
     * 
     * @see https://developer.wordpress.org/plugins/hooks/ WordPress hooks
     * @see WPEventCreator                                 Event creator class.
     */
    final function subscribe(string $event, array|string $callback, int $priority = 10, int $args = 1): void
    {
        add_filter($event, $callback, $priority, $args);
    }
}
