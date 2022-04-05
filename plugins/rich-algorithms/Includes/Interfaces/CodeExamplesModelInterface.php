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

interface CodeExamplesModelInterface
{
    /**
     * Gets the code example models.
     * 
     * @return array<string|int, CodeExampleModel>
     */
    public function getCodeExamples(): array;
}
