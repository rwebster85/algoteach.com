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
     * Registers an object for event callback with the WordPress Plugin API.
     */
    final function subscribe(string $event, object $caller, string $callback, int $priority = 10, int $args = 1): void
    {
        add_filter($event, [$caller, $callback], $priority, $args);
    }
}
