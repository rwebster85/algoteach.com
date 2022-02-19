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
    private array $test_classes = [];

    /**
     * An array of strings containing the fully qualified class names of each test class to skip, given in the config file.
     * 
     * @var string[]
     */
    private array $excluded_classes;

    /**
     * An array of strings containing the fully qualified method names of each test to skip, given in the config file.
     * 
     * @var string[]
     */
    private array $excluded_tests;

    /**
     * @uses TestsConfiguration::getExcludedClasses()
     * @uses TestsConfiguration::getExcludedTests()
     * @uses TestSuite::setTests()
     * 
     * @var string[]
     */
    public function __construct(
        private TestsConfiguration $config
    ) {
        $this->excluded_classes = $config->getExcludedClasses();
        $this->excluded_tests = $config->getExcludedTests();
        $this->setTests();
    }

    /**
     * Assigns TestSuite::$test_classes to all valid test classes found from the test folder.
     * 
     * @uses TestsConfiguration::getTestsFolder()
     * @uses TestSuite::getTestsFromPath()
     * 
     * @return void
     */
    private function setTests(): void
    {
        $test_path = $this->config->getTestsFolder();
        $this->test_classes = $this->getTestsFromPath($test_path);
    }

    /**
     * Generates an array of TestClass objects for all valid test classes in the given $path.
     * 
     * @param string $path
     * 
     * @uses \RecursiveDirectoryIterator
     * @uses \RecursiveIteratorIterator
     * @uses \SplFileInfo
     * @uses TestClass
     * 
     * @return TestClass[]
     */
    private function getTestsFromPath(string $path): array
    {
        $test_classes = [];

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
                $test_classes[] = $test;
            }
        }

        return $test_classes;
    }

    /**
     * Get an array of stored TestClass objects.
     * 
     * @uses TestSuite::$test_classes
     * 
     * @return TestClass[]
     */
    public function getTestClasses(): array
    {
        return $this->test_classes;
    }

    /**
     * Iterates over TestSuite::$test_classes, verifies the files exist, includes them, then calls run() on each of the classes.
     * 
     * @uses \file_exists()
     * @uses Application::getTestResults()
     * @uses TestUtil::isTestClass()
     * 
     * @return void
     */
    public function run(): void
    {
        /** @var TestClass $test_class */
        foreach ($this->test_classes as $test_class) {
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
            }
        }
    }
}
