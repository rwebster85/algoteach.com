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

interface PluginInterface
{
    public function getVersion(): string;

    public function getName(): string;

    public function getMainFile(): string;

    public function activated(): void;

    public function deactivated(): void;

    public function pluginsLoadedSetup(): void;

    public function initSetup(): void;
}
