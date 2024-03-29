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

use RichWeb\Algorithms\Packages\AlgorithmPackage;

interface AlgorithmPackageManagerInterface
{
    /**
     * Returns all the algorithm packages found as a key/value pair.
     * 
     * Key is the fully qualified package class name, value is the package object.
     * 
     * @return array<string, AlgorithmPackage>
     */
    public function getPackages(): array;
}
