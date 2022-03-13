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

namespace RichWeb\Algorithms\Abstracts;

use RichWeb\Algorithms\Interfaces\EventCreatorInterface;
use RichWeb\Algorithms\Interfaces\EventSubscriberInterface;
use RichWeb\Algorithms\Interfaces\PluginInterface;
use RichWeb\Algorithms\Interfaces\SubscribesToEventsInterface;
use RichWeb\Algorithms\Project;

abstract class AbstractPlugin implements PluginInterface, SubscribesToEventsInterface
{
    protected Project $project;

    protected string $name = '';

    protected string $version = '';

    protected string $main_directory;

    protected EventSubscriberInterface $event_subscriber;

    protected EventCreatorInterface $event_creator;

    /**
     * The array of requirements for this plugin.
     */
    protected array $requirements;

    /**
     * Builds the plugin.
     * 
     * @return void
     */
    abstract protected function build(): void;

    public function getVersion(): string
    {
        return $this->version;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getMainFile(): string
    {
        return $this->file;
    }
}
