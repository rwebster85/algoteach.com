<?php

declare(strict_types=1);

namespace RichPHPTests;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

final class TestSuite
{
    private array $tests;

    private array $excluded_tests;

    public function __construct(
        private TestsConfiguration $config
    ) {
        $this->excluded_tests = $config->getExcludedTests();
        $this->setTests();
    }

    private function setTests(): void
    {
        $test_path = $this->config->getTestsFolder();
        $this->tests = $this->getTestsFromPath($test_path);
    }

    private function getTestsFromPath(string $path): array
    {
        $tests = [];

        $folder = new RecursiveDirectoryIterator(
            $path,
            RecursiveDirectoryIterator::SKIP_DOTS
        );
        
        $files = new RecursiveIteratorIterator($folder);

        foreach($files as $file) {
            // $file is an SplFileInfo object
            if (
                $file->getFileName() != 'bootstrap.php'
                && $file->getExtension() == 'php'
            ) {
                $test = new TestClass(
                    $file->getFileName(),
                    str_replace('.php', '', $file->getFileName()),
                    $file->getPath() . DIRECTORY_SEPARATOR
                );
                $tests[] = $test;
            }
        }

        return $tests;
    }

    public function getTests(): array
    {
        return $this->tests;
    }

    public function run(): void
    {
        foreach ($this->tests as $test) {
            if (!file_exists($test->getFullPath())) {
                continue;
            }

            if (in_array($test->getClassName(), $this->excluded_tests)) {
                Application::getTestResults()->addSkippedFile();
                continue;
            }

            include_once $test->getFullPath();

            if (
                class_exists($test->getClassName())
                && TestUtil::isTestClass($test->getClassName())
            ) {
                $class_name = $test->getClassName();
                $test_class = new $class_name();
                $test_class->buildTests();
                $test_class->run();
            }
        }
    }
}
