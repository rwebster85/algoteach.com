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
     * Creates a new event that other objects can subscribe to using the WordPress Plugin API.
     */
    final function create(string $event, mixed ...$args): void
    {
        do_action($event, $args);
    }
}
