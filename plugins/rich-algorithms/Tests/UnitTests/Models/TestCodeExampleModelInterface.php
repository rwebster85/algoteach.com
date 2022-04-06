<?php

namespace RichAlgoUnitTests\Models;

use RichPHPTests\Attributes;
use RichPHPTests\TestCase;
use RichWeb\Algorithms\CodeExamples\CodeExampleModel;
use RichWeb\Algorithms\Interfaces\CodeExampleInterface;

class TestCodeExampleModelInterface extends TestCase
{
    private array $example;

    private CodeExampleInterface $model;

    public function setUpClass(): void
    {
        $this->example = [
            'code' => '<?php echo hello; ?>',
            'lang' => 'php',
            'vers' => '1.5',
            'info' => 'This is a PHP example.',
        ];

        $this->model = new CodeExampleModel($this->example, ['php' => 'PHP']);
    }

    public function testGetLanguage(): void
    {
        $lang = $this->model->getLanguage();
        test($lang)->stringMatches('php');
    }

    public function testGetLanguageFormatted(): void
    {
        $formatted = $this->model->getLanguageFormatted();
        test($formatted)->stringMatches('PHP');
    }

    public function testGetLanguageVersion(): void
    {
        $vers = $this->model->getLanguageVersion();
        test($vers)->stringMatches('1.5');
    }

    public function testGetInfo(): void
    {
        $info = $this->model->getInfo();
        test($info)->stringMatches('This is a PHP example.');
    }

    public function testGetCode(): void
    {
        $code = $this->model->getCode();
        test($code)->stringMatches('<?php echo hello; ?>');
    }
}
