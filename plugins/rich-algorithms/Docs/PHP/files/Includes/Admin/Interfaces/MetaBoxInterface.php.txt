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

namespace RichWeb\Algorithms\Admin\Interfaces;

/**
 * Interface shared by all Meta Box objects.
 */
interface MetaBoxInterface
{
    /**
     * Adds the meta box.
     * 
     * @uses \add_meta_box() WP function
     * 
     * @return void
     */
    public function add(): void;

    /**
     * Outputs the HTML inside the meta box.
     * 
     * @param \WP_Post $post
     * 
     * @uses \get_post_meta() WP function
     * 
     * @return void
     */
    public function html(\WP_Post $post): void;

    /**
     * Saves the value for the meta box.
     * 
     * @param int $post_id
     * 
     * @uses \update_post_meta() WP function
     * 
     * @return void
     */
    public function save(int $post_id): void;

    /**
     * Called after construction to handle the actions.
     * 
     * @return void
     */
    public function build(): void;
}
