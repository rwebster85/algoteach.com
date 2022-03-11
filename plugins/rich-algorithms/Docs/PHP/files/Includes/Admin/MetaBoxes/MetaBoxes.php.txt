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

namespace RichWeb\Algorithms\Admin\MetaBoxes;

use RichWeb\Algorithms\Interfaces\AlgorithmPackageInterface;
use RichWeb\Algorithms\Interfaces\HasRunnerInterface;

final class MetaBoxes implements HasRunnerInterface
{
    /**
     * Create a new instance of MetaBoxes which builds all required meta boxes.
     * 
     * @param array<string, AlgorithmPackageInterface> $packages The available algorithm packages.
     * @param array<string, string> $code_languages              The coding languages available with the syntax highlighter.
     */
    public function __construct(
        private array $packages,
        private array $code_languages
    ) {}

    /**
     * Runs the class init functions not handled during construction.
     */
    public function run(): void
    {
        (new AlgorithmPackageMetaBox(...$this->packages))->build();
        (new AlgorithmCodeExamplesMetaBox($this->code_languages))->build();
    }
}
