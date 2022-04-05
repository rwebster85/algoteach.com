<?php

namespace RichAlgoUnitTests;

use RichPHPTests\Attributes;
use RichPHPTests\TestCase;
use RichWeb\Algorithms\CodeExamples\CodeExampleModel;
use RichWeb\Algorithms\CodeExamples\CodeExamplesModel;

class TestCodeExamplesModelInterface extends TestCase
{
    public function testGetCodeExamplesModelInArray(): void
    {
        $code_example = [
            'code' => '<?php echo hello; ?>',
            'lang' => 'php',
            'vers' => '1.5',
            'info' => 'This is a PHP example.',
        ];

        $example_model = new CodeExampleModel($code_example, ['php' => 'PHP']);

        $examples[] = $example_model;

        $model = new CodeExamplesModel($examples);

        $examples = $model->getCodeExamples();
        test($examples)->arrayHasValue($example_model);
    }

    public function testGetCodeExamplesOne(): void
    {
        $code_example = [
            'code' => '<?php echo hello; ?>',
            'lang' => 'php',
            'vers' => '1.5',
            'info' => 'This is a PHP example.',
        ];

        $example_model = new CodeExampleModel($code_example, ['php' => 'PHP']);

        $examples[] = $example_model;

        $model = new CodeExamplesModel($examples);

        $examples = $model->getCodeExamples();
        test($examples)->arrayIsSize(1);
    }

    public function testGetCodeExamplesTwo(): void
    {
        $code_example = [
            'code' => '<?php echo hello; ?>',
            'lang' => 'php',
            'vers' => '1.5',
            'info' => 'This is a PHP example.',
        ];

        $example_model = new CodeExampleModel($code_example, ['php' => 'PHP']);

        $examples[] = $example_model;
        $examples[] = $example_model;

        $model = new CodeExamplesModel($examples);

        $examples = $model->getCodeExamples();
        test($examples)->arrayIsSize(2);
    }

    public function testGetCodeExamplesEmpty(): void
    {
        $model = new CodeExamplesModel([]);
        $examples = $model->getCodeExamples();
        test($examples)->arrayIsSize(0);
    }
}
