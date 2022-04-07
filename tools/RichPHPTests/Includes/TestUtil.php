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
     * Checks that a concrete test class has a method, rather than the parent TestCase class.
     * 
     * @param ReflectionMethod $method
     * 
     * @return bool
     */
    public static function testClassHasMethod(ReflectionMethod $method): bool
    {
        return ($method->getDeclaringClass()->isSubclassOf('RichPHPTests\TestCase'));
    }

    /**
     * Verifies that a class (object or a class name) is a sub class of TestCase.
     * 
     * @param object|string $class
     * 
     * @return bool
     */
    public static function isTestClass(object|string $class): bool
    {
        if (is_string($class) || !$class instanceof ReflectionClass) {
            $class = new ReflectionClass($class);
        }
        return ($class->isSubclassOf('RichPHPTests\TestCase'));
    }

    public static function hasSkippedAttribute(ReflectionClass|ReflectionMethod $class_or_method): bool
    {
        $attributes = $class_or_method->getAttributes('RichPHPTests\Attributes\Skip');
        return !empty($attributes);
    }

    public static function hasIncludedAttribute(ReflectionClass|ReflectionMethod $class_or_method): bool
    {
        $attributes = $class_or_method->getAttributes('RichPHPTests\Attributes\Run');
        return !empty($attributes);
    }
}
