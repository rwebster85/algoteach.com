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
use RichWeb\Algorithms\Packages\AlgorithmPackage;
use RichWeb\Algorithms\Interfaces\AlgorithmPackageInterface;

use const DIRECTORY_SEPARATOR as SEP;

class TestAlgorithmPackage extends TestCase
{
    private string $config_path;

    private AlgorithmPackageInterface $package;

    public function setUpClass(): void
    {
        $this->config_path = __DIR__ . SEP . 'algorithm.json';
        $this->package     = new AlgorithmPackage($this->config_path);
    }

    public function testPackagePathValid(): void
    {
        test($this->package->getConfigPath())->stringNotMatch('');
    }

    public function testPackageGetClass(): void
    {
        test($this->package->getClass())->stringMatches('MockPointInPolygon');
    }

    public function testPackageGetNamespace(): void
    {
        test($this->package->getNamespace())->stringMatches('RichWeb\\Algorithms\\Algorithm');
    }

    public function testPackageGetName(): void
    {
        test($this->package->getName())->stringMatches('Mock Point In Polygon');
    }

    public function testPackageGetVersion(): void
    {
        test($this->package->getVersion())->stringMatches('1.9.6');
    }

    public function testPackageGetScriptsOne(): void
    {
        test($this->package->getScripts()[0])->stringMatches('polygon.js');
    }

    public function testPackageGetScriptsTwo(): void
    {
        test($this->package->getScripts()[1])->stringMatches('polygon2.js');
    }

    public function testPackageGetStylesOne(): void
    {
        test($this->package->getStyles()[0])->stringMatches('polygon.css');
    }

    public function testPackageGetStylesTwo(): void
    {
        test($this->package->getStyles()[1])->stringMatches('polygon2.css');
    }

    public function testPackageGetPath(): void
    {
        test($this->package->getPath())->stringMatches(__DIR__ . SEP . 'MockPointInPolygon.php');
    }

    public function testPackageGetQualifiedClassName(): void
    {
        test($this->package->getQualifiedClassName())->stringMatches('RichWeb\\Algorithms\\Algorithm\\MockPointInPolygon');
    }
}
