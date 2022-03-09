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

use RichWeb\Algorithms\Project;
use RichWeb\Algorithms\Interfaces\SingletonInterface;

abstract class AbstractSingletonPlugin extends AbstractPlugin implements SingletonInterface
{
    /**
     * The single instance of the class.
     */
    private static ?self $instance = null;

    /**
     * Main Class Instance.
     *
     * Ensures only one instance of this class is loaded or can be loaded.
     * 
     * @return self
     */
    public static function instance(?Project $project): ?self
    {
        if (is_null(self::$instance)) {
            self::$instance = new static($project);
            self::$instance->build();
        }
        return self::$instance;
    }

    abstract protected function __construct(Project $project);
}
