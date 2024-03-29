# RichPHPTests

A custom PHP unit and integration testing framework to support running test suites via CLI and WI.

[![License: GPL v3](https://img.shields.io/badge/License-GPLv3-blue.svg)](https://www.gnu.org/licenses/gpl-3.0)

## Requirements

Minimum required PHP version 8.0.

## Basic Usage
From the command line:
```console
php path\to\RichPHPTests.php path\to\tests
```

Tests are discovered recursively within the `path\to\tests` folder supplied.

## Writing Tests

Test examples can be found inside the `Tests` folder for this tool.

Each test class should have its own file, with the test class having as many test methods as required.

Test classes must extend the `TestCase` class in the framework, with proper namespacing.

Test classes should be PSR-4 compliant, meaning the namespace should match the folder structure they reside in.

Each test method name must start with `test`, for example `testSomeFunction()`, have public visibility, be non-static, and return void.

Any filenames that start with 'Mock' are ignored by the test suite generator, so do not name your test classes 'Mock...'.

Example:

```php
<?php

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

## Configuration

Inside the `path\to\tests` folder is where you place your required tests `config.json` file.

Namespacing unit tests is supported. Ensure the root namespace of your test files matches that specified in the `config.json` folder. When a namespace is specified then the file/folder structure of your tests should be PSR-4 compliant.

This accepts the name for the test suite as well as any included/excluded test classes or methods (comma separated arrays), like so:

```json
{
    "name": "Some Test Suite",
    "namespace": "MyUnitTests",
    "included_classes": [
        ""
    ],
    "included_tests": [
        ""
    ],
    "excluded_classes": [
        "MyUnitTests\\SomeTest2"
    ],
    "excluded_tests": [
        "MyUnitTests\\SomeTest::testIsTrue"
    ]
}
```

Test classes and methods can be included or excluded. Inclusion overrides any exclusion. For example, if you include a specific class, only that class will have its tests run.

Class names do not need the `.php` extension added, but should be fully qualified including namespace if applicable.

Tests (methods) need the fully qualified test class name with the method name, separated by a double colon.

PHP Attributes can also be used to include or exclude classes and tests.

Classes and methods can be included by using the `Run` attribute. If any methods have the `Run` attribute, the class must also be given the `Run` attribute.

Classes and methods can also be skipped by using the `Skip` attribute.

Skip example:
```php
<?php

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

Run example:
```php
<?php

use RichPHPTests\Attributes;
use RichPHPTests\TestCase;

#[Attributes\Run] // Run only this test class
class SomeTest extends TestCase
{
    #[Attributes\Run] // run only this test
    public function testSomeFunction(): void
    {
        // ...
    }
}
```

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
**RichPHPTests** serves as an additional custom tool to be submitted against Richard Webster's Innovation Project dissertation for 2022, University of Chester module CO6008.

## Credits & APA References

PHP documentation generated using phpDocumentor.
* van Riel, M. (2021). phpDocumentor (3.3) [PHP documentation generator]. phpDocumentor. https://phpdoc.org/

PSR-4 Compliant PHP Autoloader class adapted from PHP FIG group.
* PHP FIG. (2016, July 7). PSR-4 Example Implementations. Retrieved December 8, 2021, from PHP-FIG: https://www.php-fig.org/psr/psr-4/examples/

File and class structure of framework based primarily on PHPUnit, but also JUnit, XCTest, and Pest. In-text citations are in place wherever specific code has been adapted.
* Apple Inc. (2019). XCTest [Swift Unit Testing Framework]. Apple Inc. https://developer.apple.com/documentation/xctest
* Beck, K., Gamma, E., Saff, D., & Vasudevan, K. (2021). JUnit [Java Unit Testing Framework]. The JUnit Team. https://junit.org/
* Bergmann, S. (2021). PHPUnit [PHP Unit Testing Framework]. Sebastian Bergmann. https://phpunit.de/
* Maduro, N. (2022). Pest [PHP Testing Framework]. Nuno Maduro. https://pestphp.com/

#### Specific Code Adaptations
TestUtil::isTestMethod()
* Bergmann, S. (2020). phpunit/Test.php. Retrieved January 5, 2022, from GitHub: https://github.com/sebastianbergmann/phpunit/blob/1c4fc0e68c42132b4bf38b0185058919f2dc3f31/src/Util/Test.php#L21

SourceChecker::isCli()
* Moon, S. (2020, July 30). How to Check if php is running from cli (command line). BinaryTides. Retrieved 4 January 2022, from https://www.binarytides.com/php-check-running-cli/
