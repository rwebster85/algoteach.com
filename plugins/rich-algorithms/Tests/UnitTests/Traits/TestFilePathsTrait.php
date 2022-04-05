<?php

namespace RichAlgoUnitTests\Traits;

use RichPHPTests\TestCase;

use RichWeb\Algorithms\Traits\Formatting\FilePathsTrait;

class TestFilePathsTrait extends TestCase
{
    use FilePathsTrait;

    public function testFormatSlashes(): void
    {
        $sep = DIRECTORY_SEPARATOR;
        $path = 'path/to/file.php';
        $formatted = $this->formatSlashes($path);
        test($formatted)->stringContains($sep);
    }
}
