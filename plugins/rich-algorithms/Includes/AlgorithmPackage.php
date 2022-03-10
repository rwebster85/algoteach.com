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

namespace RichWeb\Algorithms;

use RichWeb\Algorithms\Interfaces\AlgorithmPackageInterface;
use RichWeb\Algorithms\Traits\Formatting\FilePaths;

/**
 * Represents the system level information for an algorithm package.
 * 
 * @used-by AlgorithmPackageManager
 */
final class AlgorithmPackage implements AlgorithmPackageInterface
{
    use FilePaths;

    private array $config = [];

    private string $name;

    private string $class;

    private string $namespace;

    private string $version;

    private array $scripts;

    private array $styles;

    public function __construct(
        private string $config_path
    ) {
        if (file_exists($this->config_path)) {
            $this->config = $this->parseConfig();
            $this->setClass();
            $this->setNameSpace();
            $this->setName();
            $this->setVersion();
            $this->setScripts();
            $this->setStyles();
        }
    }

    private function parseConfig(): array
    {
        return json_decode(file_get_contents($this->config_path), true);
    }

    public function getConfigPath(): string
    {
        return $this->config_path;
    }

    private function setClass(): void
    {
        $this->class = (string) ($this->config['class'] ?? '');
    }

    public function getClass(): string
    {
        return $this->class;
    }

    private function setNameSpace(): void
    {
        $this->namespace = (string) ($this->config['namespace'] ?? '');
    }

    public function getNamespace(): string
    {
        return $this->namespace;
    }

    private function setName(): void
    {
        $this->name = (string) ($this->config['name'] ?? '');
    }

    public function getName(): string
    {
        return $this->name;
    }

    private function setVersion(): void
    {
        $this->version = (string) ($this->config['version'] ?? '');
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    private function setScripts(): void
    {
        $this->scripts = (array) ($this->config['scrpts'] ?? []);
    }

    public function getScripts(): array
    {
        return $this->scripts;
    }

    private function setStyles(): void
    {
        $this->styles = (array) ($this->config['styles'] ?? []);
    }

    public function getStyles(): array
    {
        return $this->styles;
    }

    public function getPath(): string
    {
        return $this->formatSlashes(dirname($this->config_path) . '/' . $this->class . '.php');
    }

    public function getQualifiedClassName(): string
    {
        return $this->getNamespace() . '\\' . $this->getClass();
    }
}
