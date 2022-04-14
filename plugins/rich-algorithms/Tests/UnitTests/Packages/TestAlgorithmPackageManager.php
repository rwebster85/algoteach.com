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

namespace RichAlgoUnitTests\Packages;

use RichPHPTests\TestCase;
use RichWeb\Algorithms\Packages\AlgorithmPackageManager;

use const DIRECTORY_SEPARATOR as SEP;

class TestAlgorithmPackageManager extends TestCase
{
    public function testPackageFound(): void
    {
        $path = __DIR__;
        $manager = new AlgorithmPackageManager($path);
        test($manager->getPackages())->arrayIsSize(1);
    }

    public function testInvalidDirectory(): void
    {
        $path = __DIR__ . SEP . 'DirectoryDoesNotExist';
        $manager = new AlgorithmPackageManager($path);
        test($manager->getPackages())->arrayIsSize(0);
    }
}
