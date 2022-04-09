<?php

namespace RichAlgoUnitTests\Traits;

use RichPHPTests\TestCase;

use RichWeb\Algorithms\Traits\Formatting\FilePathsTrait;

class TestFilePathsTrait extends TestCase
{
    use FilePathsTrait;

    public function testFormatSlashes(): void
    {
        $formatted = $this->formatSlashes('path/to/file.php');
        test($formatted)->stringContains(DIRECTORY_SEPARATOR);
    }
}
