<?php

declare(strict_types=1);

namespace RichPHPTests;

final class TestsConfiguration
{
    private array $config;

    private string $name;

    private array $excluded_tests;

    private string $bootstrap = '';

    public function __construct(
        private string $config_file,
        private string $tests_folder
    ) {}

    public function buildConfig(): bool
    {
        if (file_exists($this->config_file)) {
            $this->config = json_decode(file_get_contents($this->config_file), true);
            $this->setName();
            $this->setBootstrap();
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

    private function setExcludedTests(): void
    {
        $this->excluded_tests = (array) ($this->config['exclude_tests'] ?? []);
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
