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
     * An array of strings containing the fully qualified class names of each test class to included, given in the config file.
     * 
     * If this contains any test classes, only those classes will be run.
     * 
     * @var string[]
     */
    private array $included_classes;

    /**
     * An array of strings containing the fully qualified method names of each test to included, given in the config file.
     * 
     * If this contains any test methods, only those methods will be run.
     * 
     * @var string[]
     */
    private array $included_tests;

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
        $this->included_classes = $config->getIncludedClasses();
        $this->included_tests = $config->getIncludedTests();
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

    /**
     * Returns the number of test classes that were actually instantiated.
     * 
     * @return int
     */
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

        $any_included = false;

        /**
         * This first loop filters out any invalid or excluded tests, raising errors if necessary.
         */
        foreach ($this->test_classes as $key => $test_class) {
            $qualified_name = $test_class->qualifiedClassName();

            $path = $test_class->getFullPath();
            if (!file_exists($path)) {
                $this->addInvalidTest($test_class, "File '$path' does not exist");
                unset($this->test_classes[$key]);
                continue;
            }

            if (!$autoload) {
                include_once $path;
            }

            if (!class_exists($qualified_name)) {
                $this->addInvalidTest($test_class, "Class '$qualified_name' does not exist");
                unset($this->test_classes[$key]);
                continue;
            }

            if (!TestUtil::isTestClass($qualified_name)) {
                unset($this->test_classes[$key]);
                continue;
            }

            if ($this->isTestClassExcluded($qualified_name)) {
                Application::getTestResults()->addSkippedFile();
                unset($this->test_classes[$key]);
                continue;
            }

            if ($this->hasTestClassIncluded($qualified_name)) {
                $any_included = true;
            }
        }

        $this->test_classes = array_filter($this->test_classes);

        foreach ($this->test_classes as $test_class) {
            $qualified_name = $test_class->qualifiedClassName();

            if ($any_included || !empty($this->included_classes)) {
                if (!$this->isTestClassIncluded($qualified_name)) {
                    Application::getTestResults()->addSkippedFile();
                    continue;
                }
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

    private function isTestClassIncluded(string $qualified_name): bool
    {
        return (
            in_array($qualified_name, $this->included_classes)
            || $this->hasTestClassIncluded($qualified_name)
        );
    }

    private function hasTestClassIncluded(string $qualified_name): bool
    {
        return (
            TestUtil::hasIncludedAttribute(new ReflectionClass($qualified_name))
        );
    }
}
