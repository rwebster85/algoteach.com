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

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ReflectionClass;

final class TestSuite
{
    /**
     * Array of TestClass objects. These are potential classes for testing.
     * 
     * @var TestClass[]
     */
    private array $test_classes = [];

    /**
     * Array of TestClass objects that were not valid tests to run.
     * 
     * @var TestClass[]
     */
    private array $test_classes_invalid = [];

    /**
     * An array of strings containing the fully qualified class names of each test class to skip, given in the config file.
     * 
     * @var string[]
     */
    private array $excluded_classes;

    /**
     * The number of test files that were instantiated (valid test classes).
     * 
     * @var int
     */
    private int $instantiated_tests = 0;

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

        foreach($files as $file) {
            assert($file instanceof \SplFileInfo);
            if (
                $file->getFilename() != 'bootstrap.php'
                && $file->getExtension() == 'php'
                && !str_starts_with($file->getFilename(), 'Mock')
            ) {
                $test = new TestClass(
                    $file->getFileName(),
                    str_replace('.php', '', $file->getFileName()),
                    $this->config->getNamespace(),
                    $file->getPath() . DIRECTORY_SEPARATOR,
                    $this->config->getTestsFolder()
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
     * Get an array of arrays with stored TestClass objects whose classes were not able to be instantiated.
     * 
     * Inner arrays are key-value pairs, 'class' is the TestClass object and 'reason' is the reason.
     * 
     * @return array[]
     */
    public function getInvalidTestClasses(): array
    {
        return $this->test_classes_invalid;
    }

    /**
     * Adds a new invalid test class.
     * 
     * @param TestClass $class
     * @param string $reason
     * 
     * @return void
     */
    private function addInvalidTest(TestClass $class, string $reason = ''): void
    {
        $this->test_classes_invalid[] = [
            'class'  => $class,
            'reason' => $reason
        ];
    }

    public function getInstantiatedTestsCount(): int
    {
        return $this->instantiated_tests;
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
        $autoload = (!empty($this->config->getNamespace()));

        foreach ($this->test_classes as $test_class) {
            $path = $test_class->getFullPath();
            if (!file_exists($path)) {
                $this->addInvalidTest($test_class, "File '$path' does not exist");
                continue;
            }

            if (!$autoload) {
                include_once $path;
            }

            $qualified_name = $test_class->qualifiedClassName();

            if (!class_exists($qualified_name)) {
                $this->addInvalidTest($test_class, "Class '$qualified_name' does not exist");
                continue;
            }

            if (!TestUtil::isTestClass($qualified_name)) {
                //$this->addInvalidTest($test_class, "Class '$qualified_name' is not a valid test class");
                continue;
            }

            if ($this->isTestClassExcluded($qualified_name)) {
                Application::getTestResults()->addSkippedFile();
                continue;
            }

            $test_class = new $qualified_name($this->config);
            $this->instantiated_tests++;
        }
    }

    private function isTestClassExcluded(string $qualified_name): bool
    {
        return (
            in_array($qualified_name, $this->excluded_classes)
            || TestUtil::hasSkippedAttribute(new ReflectionClass($qualified_name))
        );
    }
}
