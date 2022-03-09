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

namespace RichWeb\Algorithms;

use RichWeb\Algorithms\Traits\Formatting;
use RichWeb\Algorithms\Abstracts\AbstractSyntaxHighlighter;
use Stringable;

class CodeExample implements Stringable
{
    use Formatting\FilePaths;
    use Formatting\Strings;

    private string $code;

    private string $lang;

    private string $info;

    public function __construct(
        private array $example,
        private AbstractSyntaxHighlighter $syntax
    ) {
        $this->code = ($example['content'] ?? '');
        $this->lang = ($example['lang'] ?? '');
        $this->info = ($example['info'] ?? '');
    }

    public function getLanguage(): string
    {
        return $this->lang;
    }

    public function getLanguageFormatted(): string {
        $langs = $this->syntax->languages();

        return ($langs[$this->lang] ?? '');
    }

    public function getInfo(): string
    {
        return $this->info;
    }

    public function getInfoAutoP(): string
    {
        return wpautop($this->info);
    }

    public function getCode(): string
    {
        return $this->code;
    }
    
    public function __toString(): string
    {
        ob_start();

        include dirname(__FILE__) . $this->formatSlashes('\Content\CodeExampleContent.php');

        $content = ob_get_clean();

        return $content;
    }
}
