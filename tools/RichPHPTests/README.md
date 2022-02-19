# RichPHPTests

A custom PHP unit and integration testing framework to support running test suites via CLI and WI.

## Basic Usage
From the command line:
```console
php path\to\RichPHPTests.php path\to\tests
```

Tests are discovered recursively within the `path\to\tests` folder supplied.

Inside the `path\to\tests` folder is where you place your required tests `config.json` file.

This accepts the name for the test suite as well as any excluded test classes or methods (comma separated arrays), like so:

```json
{
    "name": "Some Test Suite",
    "namespace": "MyUnitTests",
    "excluded_classes": [
        "MyUnitTests\\SomeTest2"
    ],
    "excluded_tests": [
        "MyUnitTests\\SomeTest::testIsTrue"
    ]
}
```

Excluded class names do not need the `.php` extension added, but should be fully qualified including namespace if applicable.

Excluded tests (methods) need the fully qualified test class name with the method name, separated by a double colon.

Test classes and methods can also be skipped by using the `Skip` attribute.

```php
<?php

declare(strict_types=1);

use RichPHPTests\Attributes;
use RichPHPTests\TestCase;

#[Attributes\Skip] // skip this class
class SomeTest extends TestCase
{
    #[Attributes\Skip] // skip this test
    public function testSomeFunction(): void
    {
        // ...
    }
}
```

## Writing Tests

Test examples can be found inside the `Tests` folder for this tool.

Each test class should have its own file, with the test class having as many test methods as required.

Test classes must extend the `TestCase` class in the framework, with proper namespacing.

Each test method name must start with `test`, for example `testSomeFunction()`, have public visibility, be non-static, and return void.

Example:

```php
<?php

declare(strict_types=1);

use RichPHPTests\TestCase;

class SomeTest extends TestCase
{
    public function testSomeFunction(): void
    {
        $variable = true;
        test($variable)->isTrue();
    }
}
```

The syntax for actually performing a test is `test($some_value)->testMethod()`. In the example above, checking if a variable is `true` requires the code `test($variable)->isTrue()`.

When calling the function `test()`, it returns a new instance of the `Test` class. The variable passed in this function call is stored in the class as `$value`.

Available test methods can be found in the [Includes\Test.php](Includes/Test.php) class.

Namespacing unit tests is support. Ensure the namespace of your test files matches that specified in the `config.json` folder.

### Setup and Teardown

You can add methods to your test classes for setting up and tearing down any variables needed for each test.

The `setUp()` and `tearDown()` methods are called before and after every test method, respectively. `setUpClass()` is called only once before any test methods in a class, and `tearDownClass()` is called only once after all test methods in a class have run. Make note of the visibility and return types.

```php
protected function setUp(): void {}

protected function tearDown(): void {}

public function setUpClass(): void {}

public function tearDownClass(): void {}
```

## Example CLI Output

When run from the command line, assuming no fatal errors were raised, the output will look something like this for all passing tests:

```console
> php "path\to\RichPHPTests.php" "path\to\tests\folder"

Running test suite: Some Test Suite
Tests complete.
Tests ran: 9, Passed: 9, Failed: 0. Skipped Files: 1 - Skipped Tests: 0
```

Or if any tests failed, the output will look like this:

```console
> php "path\to\RichPHPTests.php" "path\to\tests\folder"

Running test suite: Some Test Suite
Tests complete.
Tests ran: 9, Passed: 7, Failed: 2. Skipped Files: 1, Skipped Tests: 0
The following tests failed:
SomeTest::testStringMatches2 : File: SomeTest.php - Line: 24 - Expected: 'String2' - Actual: 'String1' - Error: Strings are not the same.
SomeTest::testArrayIsEmpty : File: SomeTest.php - Line: 44 - Expected: 0 - Actual: 1 - Error: Array is not the right size.
```

## Additional Information

You can include a `bootstrap.php` file in your root `path\to\tests` directory if required. This can be used to carry out any additional logic or setup for the entire test suite, for example to autoload any classes or define constants.

## Purpose
**RichPHPTests** serves as an additional project to be submitted against Richard Webster's Innovation Project dissertation for 2022, University of Chester module CO6008.

## Credits & APA References

PHP documentation generated using phpDocumentor.
* van Riel, M. (2021). phpDocumentor (3.3) [PHP documentation generator]. phpDocumentor. https://phpdoc.org/

File and class structure of framework based primarily on PHPUnit, but also JUnit and XCTest. In-text citations are in place wherever specific code has been adapted.
* Apple Inc. (2019). XCTest [Swift Unit Testing Framework]. Apple Inc. https://developer.apple.com/documentation/xctest
* Beck, K., Gamma, E., Saff, D., & Vasudevan, K. (2021). JUnit [Java Unit Testing Framework]. The JUnit Team. https://junit.org/
* Bergmann, S. (2021). PHPUnit [PHP Unit Testing Framework]. Sebastian Bergmann. https://phpunit.de/

#### Specific Code Adaptations
TestUtil::isTestMethod()
* Bergmann, S. (2020). PHPUnit – The PHP Testing Framework. PHPUnit. Retrieved 5 January 2022, from https://phpunit.de/

SourceChecker::isCli()
* Moon, S. (2020, July 30). How to Check if php is running from cli (command line). BinaryTides. Retrieved 4 January 2022, from https://www.binarytides.com/php-check-running-cli/
