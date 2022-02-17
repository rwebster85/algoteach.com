<?php

declare(strict_types=1);

namespace RichPHPTests;

use ReflectionClass;
use ReflectionMethod;

/**
 * TestUtil contains general utility static methods.
 */
class TestUtil
{
    /**
     * Verifies that a test method from a test class meets the necessary criteria.
     * 
     * @param ReflectionMethod $method
     * 
     * @return bool
     */
    // Code function adapted from Sebastian Bergmann, 2020
    public static function isTestMethod(ReflectionMethod $method): bool
    {
        return ($method->isPublic() && str_starts_with($method->getName(), 'test'));
    }
    //end of adapted code

    /**
     * Checks that a test class has a method, rather than the parent class.
     * 
     * @param ReflectionMethod $method
     * 
     * @return bool
     */
    public static function testClassHasMethod(ReflectionMethod $method): bool
    {
        return ($method->getDeclaringClass()->getName() !== 'RichPHPTests\TestCase');
    }

    /**
     * Verifies that a class name is a sub class of TestCase.
     * 
     * @param string $class_name
     * 
     * @return bool
     */
    public static function isTestClass(string $class_name): bool
    {
        $class = new ReflectionClass($class_name);
        return ($class->isSubclassOf('RichPHPTests\TestCase'));
    }
}
