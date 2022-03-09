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

namespace RichWeb\Algorithms\Admin\Abstracts;

use RichWeb\Algorithms\Admin\Interfaces\MetaBoxInterface;

/**
 * All meta boxes extend AbstractMetaBox, which implements the MetaBoxInterface interface.
 * Three abstract methods are defined that require implementation in the concrete classes.
 * 
 * `actions()` is final, private, and implemented in AbstractMetaBox.
 * `run()` is final and called after construction of concrete class to initiate actions.
 *
 * Example usage:
 *
 * ```php
 * class MetaBox extends AbstractMetaBox
 * {
 *     public function add()  { // implement }
 *     public function save() { // implement }
 *     public function html() { // implement }
 * }
 * 
 * // Instantiate the class somewhere else.
 * $meta_box = new MetaBox();
 * $meta_box->build();
 * ```
 */
abstract class AbstractMetaBox implements MetaBoxInterface
{
    abstract public function add(): void;
    abstract public function html(\WP_Post $post): void;
    abstract public function save(int $post_id): void;

    /**
     * Runs the class init functions not handled during construction.
     */
    final public function build(): void
    {
        $this->actions();
    }

    /**
     * Hooks into the WP actions for adding and saving meta boxes.
     * 
     * @see https://developer.wordpress.org/reference/hooks/add_meta_boxes/ WP action
     * @see https://developer.wordpress.org/reference/hooks/save_post/ WP action
     * 
     * @return void
     */
    private function actions(): void
    {
        add_action('add_meta_boxes', [$this, 'add']);
        add_action('save_post', [$this, 'save']);
    }
}
