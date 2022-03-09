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

use RichWeb\Algorithms\Abstracts\AbstractSyntaxHighlighter;
use RichWeb\Algorithms\Setup\PrismSyntaxtHighlighterScripts;

class PrismSyntaxHighlighter extends AbstractSyntaxHighlighter
{
    public function __construct()
    {
        $this->scripts = new PrismSyntaxtHighlighterScripts();
        $this->loadScripts();
    }

    /**
     * Returns a key/value array of supported code example languages. Key is the highlighter name, value is the name formatted for display.
     * 
     * @return array<string, string>
     */
    public function languages(): array
    {
        return [
            'atom'       => 'Atom',
            'c'          => 'C',
            'clike'      => 'C-like',
            'cpp'        => 'C++',
            'csharp'     => 'C#',
            'css'        => 'CSS',
            'html'       => 'HTML',
            'javascript' => 'JavaScript',
            'markup'     => 'Markup',
            'mathml'     => 'MathML',
            'php'        => 'PHP',
            'python'     => 'Python',
            'rss'        => 'RSS',
            'ssml'       => 'SSML',
            'svg'        => 'SVG',
            'swift'      => 'Swift',
            'xml'        => 'XML',
        ];
    }
}
