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
