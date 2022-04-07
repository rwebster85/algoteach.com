<?php

/*
 * This file is part of RichPHPTests.
 *
 * Copyright (c) Richard Webster
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace RichPHPTests;

final class TestsConfiguration
{
    private array $config;

    private string $name;

    private array $included_classes;

    private array $included_tests;

    private array $excluded_classes;

    private array $excluded_tests;

    private string $bootstrap = '';

    public function __construct(
        private string $config_file,
        private string $tests_folder
    ) {
        $this->buildConfig();
    }

    public function buildConfig(): bool
    {
        if (file_exists($this->config_file)) {
            $this->config = json_decode(file_get_contents($this->config_file), true);
            $this->setName();
            $this->setNameSpace();
            $this->setBootstrap();
            $this->setIncludedClasses();
            $this->setIncludedTests();
            $this->setExcludedClasses();
            $this->setExcludedTests();
        }

        return true;
    }

    private function setName(): void
    {
        $this->name = (string) ($this->config['name'] ?? '');
    }

    public function getName(): string
    {
        return $this->name;
    }

    private function setNamespace(): void
    {
        $this->namespace = (string) ($this->config['namespace'] ?? '');
    }

    public function getNamespace(): string
    {
        return $this->namespace;
    }

    public function setBootstrap(): void
    {
        $bootstrap = $this->tests_folder . DIRECTORY_SEPARATOR . 'bootstrap.php';
        if (file_exists($bootstrap)) {
            $this->bootstrap = $bootstrap;
        }
    }

    public function getBootstrap(): string
    {
        return $this->bootstrap;
    }

    private function setIncludedClasses(): void
    {
        $this->included_classes = (array) array_filter(($this->config['included_classes'] ?? []));
    }

    private function setIncludedTests(): void
    {
        $this->included_tests = (array) array_filter(($this->config['included_tests'] ?? []));
    }

    public function getIncludedClasses(): array
    {
        return $this->included_classes;
    }

    public function getIncludedTests(): array
    {
        return $this->included_tests;
    }

    private function setExcludedClasses(): void
    {
        $this->excluded_classes = (array) array_filter(($this->config['excluded_classes'] ?? []));
    }

    private function setExcludedTests(): void
    {
        $this->excluded_tests = (array) array_filter(($this->config['excluded_tests'] ?? []));
    }

    public function getExcludedClasses(): array
    {
        return $this->excluded_classes;
    }

    public function getExcludedTests(): array
    {
        return $this->excluded_tests;
    }

    public function getTestsFolder(): string
    {
        return $this->tests_folder;
    }
}
