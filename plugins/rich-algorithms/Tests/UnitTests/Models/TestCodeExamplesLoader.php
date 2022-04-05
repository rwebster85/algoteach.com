<?php

namespace RichAlgoUnitTests;

use RichPHPTests\Attributes;
use RichPHPTests\TestCase;
use RichWeb\Algorithms\CodeExamples\CodeExampleModel;
use RichWeb\Algorithms\CodeExamples\CodeExamplesLoader;
use RichWeb\Algorithms\Interfaces\CodeExamplesLoaderInterface;

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
