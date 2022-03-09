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

namespace RichWeb\Algorithms\Abstracts;

use RichWeb\Algorithms\Abstracts\AbstractScripts;
use RichWeb\Algorithms\Interfaces\SyntaxHighlighterInterface;

abstract class AbstractSyntaxHighlighter implements SyntaxHighlighterInterface
{
    /**
     * The scripts object that loads the necessary JS and CSS files.
     * 
     * @var AbstractScripts
     */
    protected AbstractScripts $scripts;

    /**
     * Loads the necessary scripts object that extends AbstractScripts
     * 
     * @return void
     */
    protected function loadScripts(): void
    {
        $this->scripts->run();
    }

    /**
     * Returns a key/value array of supported code example languages. Key is the highlighter name, value is the name formatted for display.
     * 
     * @return array<string, string>
     */
    abstract public function languages(): array;
}
