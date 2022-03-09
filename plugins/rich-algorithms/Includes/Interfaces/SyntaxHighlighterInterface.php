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

namespace RichWeb\Algorithms\Interfaces;

interface SyntaxHighlighterInterface
{
    /**
     * Returns a key/value array of supported code example languages. Key is the highlighter name, value is the name formatted for display.
     * 
     * @return array<string, string>
     */
    public function languages(): array;
}
