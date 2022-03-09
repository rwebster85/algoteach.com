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

namespace RichWeb\Algorithms\Traits\Formatting;

trait Strings
{
    /**
     * Sanitise a string for safe usage and database storage.
     * 
     * @param string $var
     * 
     * @uses \sanitize_text_field() WP Function
     * 
     * @return string
     */
    protected function sanitise(string $var = ''): string
    {
        return sanitize_text_field($var);
    }

    /**
     * Escapes any HTML entities within a string for safe output.
     * 
     * @param string $var
     * 
     * @uses \esc_html() WP Function
     * 
     * @return string
     */
    protected function escHtml(string $var = ''): string
    {
        return esc_html($var);
    }
}
