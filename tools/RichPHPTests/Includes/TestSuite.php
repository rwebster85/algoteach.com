<?php

declare(strict_types=1);

namespace RichPHPTests;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

final class TestSuite
{
    /**
     * Array of TestClass objects.
     * 
     * @var TestClass[]
     */
    private array $tests = [];

    /**
     * @var string[]
     */
    private array $excluded_classes;

    /**
     * @var string[]
     */
    private array $excluded_tests;

    public function __construct(
        private TestsConfiguration $config
    ) {
        $this->excluded_classes = $config->getExcludedClasses();
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

        /** @var \SplFileInfo $file */
        foreach($files as $file) {
            if (
                $file->getFilename() != 'bootstrap.php'
                && $file->getExtension() == 'php'
            ) {
                $test = new TestClass(
                    $file->getFileName(),
                    str_replace('.php', '', $file->getFileName()),
                    $this->config->getNamespace(),
                    $file->getPath() . DIRECTORY_SEPARATOR
                );
                $tests[] = $test;
            }
        }

        return $tests;
    }

    /**
     * Get an array to test classes.
     * 
     * @return TestClass[]
     */
    public function getTests(): array
    {
        return $this->tests;
    }

    public function run(): void
    {
        /** @var TestClass $test_class */
        foreach ($this->tests as $test_class) {
            if (!file_exists($test_class->getFullPath())) {
                continue;
            }

            $qualified_name = $test_class->qualifiedClassName();

            if (in_array($qualified_name, $this->excluded_classes)) {
                Application::getTestResults()->addSkippedFile();
                continue;
            }

            include_once $test_class->getFullPath();

            if (
                class_exists($qualified_name)
                && TestUtil::isTestClass($qualified_name)
            ) {
                $test_class = new $qualified_name($this->config);
                $test_class->buildTests();
                $test_class->run();
            }
        }
    }
}
