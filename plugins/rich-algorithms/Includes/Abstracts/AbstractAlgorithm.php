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

use RichWeb\Algorithms\Interfaces\AlgorithmInterface;
use RichWeb\Algorithms\Interfaces\AlgorithmPackageInterface;
use RichWeb\Algorithms\Interfaces\HasRunnerInterface;
use RichWeb\Algorithms\Traits\Formatting;
use RichWeb\Algorithms\Setup\AlgorithmScripts;

abstract class AbstractAlgorithm implements AlgorithmInterface, HasRunnerInterface
{
    use Formatting\FilePaths;
    use Formatting\Strings;

    private array $code_examples;

    final public function __construct(
        private AlgorithmPackageInterface $package,
        private int $post_id
    ) {}

    final public function run(): void
    {
        $this->actions();
        $this->loadScripts();
        $this->load();
    }

    protected function actions(): void {}

    final public function loadScripts(): void
    {
        (new AlgorithmScripts($this->package))->run();
    }

    /**
     * Can be implemented in the concrete class for additional functionality. Always called from the run() method.
     * 
     * @return void
     */
    protected function load(): void {}
}
