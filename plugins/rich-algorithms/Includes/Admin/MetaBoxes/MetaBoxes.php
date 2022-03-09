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

use RichWeb\Algorithms\Abstracts\AbstractSyntaxHighlighter;
use RichWeb\Algorithms\AlgorithmPackageManager;
use RichWeb\Algorithms\Interfaces\HasRunnerInterface;

final class MetaBoxes implements HasRunnerInterface
{
    public function __construct(
        private string $main_directory,
        private AlgorithmPackageManager $algorithm_package_manager,
        private AbstractSyntaxHighlighter $syntax
    ) {}

    /**
     * Runs the class init functions not handled during construction.
     */
    public function run(): void
    {
        (new AlgorithmPackageMetaBox($this->main_directory, $this->algorithm_package_manager))->build();
        (new AlgorithmCodeExamplesMetaBox($this->main_directory, $this->syntax))->build();
    }
}
