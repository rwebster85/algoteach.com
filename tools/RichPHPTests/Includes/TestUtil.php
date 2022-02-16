<?php

declare(strict_types=1);

namespace RichPHPTests;

use ReflectionClass;
use ReflectionMethod;

class TestUtil
{
    // Code function adapted from Sebastian Bergmann, 2020
    public static function isTestMethod(ReflectionMethod $method): bool
    {
        return ($method->isPublic() && str_starts_with($method->getName(), 'test'));
    }
    //end of adapted code

    public static function isTestClass(string $class_name): bool
    {
        $class = new ReflectionClass($class_name);
        return ($class->isSubclassOf('RichPHPTests\TestCase'));
    }
}
