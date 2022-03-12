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

use RichWeb\Algorithms\Interfaces\EventSubscriberInterface;

interface SubscribesToEventsInterface
{
    /**
     * Method containing the events this object will subscribe to.
     * 
     * @return void
     */
    public function subscribeToEvents(EventSubscriberInterface $subscriber): void;
}
