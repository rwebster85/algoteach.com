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
use RichWeb\Algorithms\Interfaces\SyntaxHighlighterInterface;

final class MetaBoxes implements HasRunnerInterface
{
    /**
     * The available algorithm packages.
     * 
     * @var AlgorithmPackageInterface[]
     */
    private array $packages;
    
    /**
     * The syntax highlighter being used by the system.
     * 
     * @var SyntaxHighlighterInterface
     */
    private SyntaxHighlighterInterface $syntax;

    public function __construct(
        array $packages,
        SyntaxHighlighterInterface $syntax
    ) {
        $this->packages = $packages;
        $this->syntax = $syntax;
    }

    /**
     * Runs the class init functions not handled during construction.
     */
    public function run(): void
    {
        (new AlgorithmPackageMetaBox(...$this->packages))->build();
        (new AlgorithmCodeExamplesMetaBox($this->syntax))->build();
    }
}
