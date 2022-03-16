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

use RichWeb\Algorithms\Interfaces\CodeExampleInterface;
use RichWeb\Algorithms\Loaders\ContentLoader;
use RichWeb\Algorithms\Traits\Formatting;
use Stringable;

class CodeExample implements CodeExampleInterface, Stringable
{
    use Formatting\FilePathsTrait;

    private string $code;

    private string $lang;

    private string $vers;

    private string $info;

    public function __construct(
        private array $example,
        private array $code_languages
    ) {
        $this->code = ($example['code'] ?? '');
        $this->lang = ($example['lang'] ?? '');
        $this->vers = ($example['vers'] ?? '');
        $this->info = ($example['info'] ?? '');
    }

    public function getLanguage(): string
    {
        return $this->lang;
    }

    public function getLanguageFormatted(): string
    {
        return ($this->code_languages[$this->lang] ?? '');
    }

    public function getLanguageVersion(): string
    {
        return ($this->vers);
    }

    public function getInfo(): string
    {
        return $this->info;
    }

    public function getCode(): string
    {
        return $this->code;
    }
    
    /**
     * Returns the string representation of this code example.
     * 
     * @return string
     */
    public function __toString(): string
    {
        ob_start();

        $path = dirname(__FILE__) . $this->formatSlashes('\..\Content\CodeExampleContent.php');

        $loader = new ContentLoader($path, $this);
        $loader->loadFile();

        return ob_get_clean();
    }
}
