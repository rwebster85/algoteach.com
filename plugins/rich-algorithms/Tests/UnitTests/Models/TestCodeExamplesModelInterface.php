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

namespace RichAlgoUnitTests\Models;

use RichPHPTests\Attributes;
use RichPHPTests\TestCase;
use RichWeb\Algorithms\CodeExamples\CodeExampleModel;
use RichWeb\Algorithms\CodeExamples\CodeExamplesModel;

class TestCodeExamplesModelInterface extends TestCase
{
    public function testGetCodeExamplesModelInArray(): void
    {
        $examples = [];
        
        $code_example = [
            'code' => '<?php echo hello; ?>',
            'lang' => 'php',
            'vers' => '1.5',
            'info' => 'This is a PHP example.',
        ];

        $example_model = new CodeExampleModel(
            $code_example,
            ['php' => 'PHP']
        );

        $examples[] = $example_model;

        $model = new CodeExamplesModel($examples);

        test($model->getCodeExamples())->arrayHasValue($example_model);
    }

    public function testGetCodeExamplesOne(): void
    {
        $examples = [];

        $code_example = [
            'code' => '<?php echo hello; ?>',
            'lang' => 'php',
            'vers' => '1.5',
            'info' => 'This is a PHP example.',
        ];

        $example_model = new CodeExampleModel(
            $code_example,
            ['php' => 'PHP']
        );

        $examples[] = $example_model;

        $model = new CodeExamplesModel($examples);

        test($model->getCodeExamples())->arrayIsSize(1);
    }

    public function testGetCodeExamplesTwo(): void
    {
        $examples = [];

        $code_example = [
            'code' => '<?php echo hello; ?>',
            'lang' => 'php',
            'vers' => '1.5',
            'info' => 'This is a PHP example.',
        ];

        $example_model = new CodeExampleModel(
            $code_example,
            ['php' => 'PHP']
        );

        $examples[] = $example_model;
        $examples[] = $example_model;

        $model = new CodeExamplesModel($examples);

        test($model->getCodeExamples())->arrayIsSize(2);
    }

    public function testGetCodeExamplesEmpty(): void
    {
        $model = new CodeExamplesModel([]);

        test($model->getCodeExamples())->arrayIsSize(0);
    }
}
