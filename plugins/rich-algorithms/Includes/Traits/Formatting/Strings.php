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

    /**
     * Escapes any HTML entities within a string for safe output as an HTML attribute.
     * 
     * @param string $var
     * 
     * @uses \esc_attr() WP Function
     * 
     * @return string
     */
    protected function escAttr(string $var = ''): string
    {
        return esc_attr($var);
    }

    /**
     * Escapes any HTML entities within a string for safe output to a textarea element.
     * 
     * @param string $var
     * 
     * @uses \esc_textarea() WP Function
     * 
     * @return string
     */
    protected function escTextarea(string $var = ''): string
    {
        return esc_textarea($var);
    }

    /**
     * Sanitise content for allowed HTML elements, usually from post content.
     * 
     * @param string $var
     * 
     * @uses \wp_kses_post() WP Function
     * 
     * @return string
     */
    protected function ksesPost(string $var = ''): string
    {
        return wp_kses_post($var);
    }

    /**
     * Returns the string formatted with <p> tags, parsed from newlines.
     * 
     * @param string $var
     * 
     * @uses \wpautop WP Function
     * 
     * @return string
     */
    protected function autoP(string $var = ''): string
    {
        return wpautop($var);
    }
}
