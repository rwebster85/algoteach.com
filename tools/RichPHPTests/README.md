# RichPHPTests

A custom PHP unit and integration testing framework to support running test suites via CLI and WI.

## Basic Usage
From the command line:
```
php path\to\RichPHPTests.php path\to\tests
```

Tests are discovered recursively within the `tests` folder supplied.

Inside the `tests` folder is where you place your required tests `config.json` file.

This accepts the name for the test suite as well as any excluded test classes (comma separated array), like so:

```json
{
    "name": "Some Test Suite",
    "exclude_tests": [
        "SomeTest2"
    ]
}
```

Excluded files do not need the `.php` extension added.

## Writing Tests

Test examples can be found inside the `Tests` folder for this tool.

Each test class should have its own file, with the test class having as many test methods as required.

Test classes must extend the `TestCase` class in the framework, with proper namespacing.

Each test method name must start with `test`, have public visibility, be non-static, and return void.

Example:

```php
<?php

declare(strict_types=1);

use RichPHPTests\TestCase;

class SomeTest extends TestCase
{
    public function testIsTrue(): void
    {
        $this->assertTrue(true);
    }
}
```

Available assertion methods can be found in the [Includes\Assert\Traits](Includes/Assert/Traits) folder. Assert methods are separated out into a relevant `trait`.

## Additional Information

You can include a `bootstrap.php` file in the root `tests` directory if required. This can be used to carry out any additional logic or setup for the entire test suite, for example to autoload any classes or define constants.

## Purpose
**RichPHPTests** serves as an additional project for the Innovation Project submission for Richard Webster's dissertation for 2022, University of Chester module CO6008.
