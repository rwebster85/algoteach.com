<?php

/*
 * This file is part of Rich Algorithms.
 *
 * Copyright (c) Richard Webster
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace RichAlgoUnitTests\Loaders;

use RichPHPTests\TestCase;
use RichWeb\Algorithms\CodeExamples\CodeExamplesLoader;

class TestCodeExamplesLoader extends TestCase
{
    private array $languages;

    public function setUpClass(): void
    {
        $this->languages = [
            'php' => 'PHP',
            'js'  => 'JavaScript'
        ];
    }

    public function testBuildCodeExamplesOne(): void
    {
        $examples = [
            [
                'code' => '<?php echo hello; ?>',
                'lang' => 'php',
                'vers' => '1.5',
                'info' => 'This is a PHP example.'
            ]
        ];

        $loader = new CodeExamplesLoader($this->languages);
        $loader->buildCodeExamples($examples);
        test($loader->getCodeExamples())->arrayIsSize(1);
    }

    public function testBuildCodeExamplesTwo(): void
    {
        $examples = [
            [
                'code' => '<?php echo hello; ?>',
                'lang' => 'php',
                'vers' => '1.5',
                'info' => 'This is a PHP example.'
            ],
            [
                'code' => 'console.log("hello")',
                'lang' => 'js',
                'vers' => '1.0',
                'info' => 'This is a JavaScript example.'
            ],
        ];

        $loader = new CodeExamplesLoader($this->languages);
        $loader->buildCodeExamples($examples);
        test($loader->getCodeExamples())->arrayIsSize(2);
    }

    public function testGetCodeExamplesContainsModel(): void
    {
        $examples = [
            [
                'code' => '<?php echo hello; ?>',
                'lang' => 'php',
                'vers' => '1.5',
                'info' => 'This is a PHP example.'
            ],
            [
                'code' => 'console.log("hello")',
                'lang' => 'js',
                'vers' => '1.0',
                'info' => 'This is a JavaScript example.'
            ],
        ];

        $loader = new CodeExamplesLoader($this->languages);
        $loader->buildCodeExamples($examples);
        $example_one = $loader->getCodeExamples()[0];
        test($example_one)->isObjectOfType('RichWeb\Algorithms\CodeExamples\CodeExampleModel');
    }
}
