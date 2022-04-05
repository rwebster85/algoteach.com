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

namespace RichWeb\Algorithms\CodeExamples;

use RichWeb\Algorithms\Interfaces\CodeExamplesModelInterface;
use RichWeb\Algorithms\Interfaces\ModelInterface;
use RichWeb\Algorithms\Loaders\ContentLoader;
use RichWeb\Algorithms\Traits\Formatting;

class CodeExamplesModel implements CodeExamplesModelInterface, ModelInterface
{
    use Formatting\FilePathsTrait;

    /**
     * Creates a new code examples model
     * 
     * @param array<string|int, CodeExampleModel> $code_examples
     */
    public function __construct(
        private array $code_examples = []
    ) {}

    public function getCodeExamples(): array
    {
        return $this->code_examples;
    }
    
    /**
     * Returns the string representation of this code example.
     * 
     * @return string
     */
    public function getContent(): string
    {
        ob_start();

        $path = dirname(__FILE__) . $this->formatSlashes('\..\Content\CodeExamplesContent.php');

        $loader = new ContentLoader($path, $this);
        $loader->loadFile();

        return ob_get_clean();
    }
}
