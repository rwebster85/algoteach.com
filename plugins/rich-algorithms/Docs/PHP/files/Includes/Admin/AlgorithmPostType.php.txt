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

namespace RichWeb\Algorithms\Admin;

use RichWeb\Algorithms\Admin\Abstracts\AbstractPostType;

final class AlgorithmPostType extends AbstractPostType
{
    public function __construct() {}

    protected function actions(): void
    {
        add_action('init', [$this, 'register'], 50);
        add_filter('get_the_archive_title', [$this, 'archivePageTitle']);
        add_filter('the_content', [$this, 'showExcerptOnArchives']);
    }

    public function archivePageTitle(string $title): ?string
    {
        if (is_post_type_archive('richweb_algorithm')) {
            return post_type_archive_title('', false);
        }

        return $title;
    }

    public function showExcerptOnArchives(string $content): ?string
    {
        if (is_post_type_archive('richweb_algorithm')) {
            if (has_excerpt()) {
                return the_excerpt();
            }
        }

        return $content;
    }

    public function register(): void
    {
        $labels = [
            'name'                  => __('Algorithms', 'rich-algo'),
            'singular_name'         => __('Algorithm', 'rich-algo'),
            'menu_name'             => __('Algorithms', 'rich-algo'),
            'name_admin_bar'        => __('Algorithms', 'rich-algo'),
            'archives'              => __('Algorithms', 'rich-algo'),
            'parent_item_colon'     => __('Parent Algorithm:', 'rich-algo'),
            'all_items'             => __('Algorithms', 'rich-algo'),
            'add_new_item'          => __('Add New Algorithm ', 'rich-algo'),
            'add_new'               => __('Add New', 'rich-algo'),
            'new_item'              => __('New Algorithm', 'rich-algo'),
            'edit_item'             => __('Edit Algorithm', 'rich-algo'),
            'update_item'           => __('Update Algorithm', 'rich-algo'),
            'view_item'             => __('View Algorithm', 'rich-algo'),
            'search_items'          => __('Search Algorithm', 'rich-algo'),
            'not_found'             => __('Not found', 'rich-algo'),
            'not_found_in_trash'    => __('Not found in Trash', 'rich-algo'),
            'featured_image'        => __('Featured Image', 'rich-algo'),
            'set_featured_image'    => __('Set featured image', 'rich-algo'),
            'remove_featured_image' => __('Remove featured image', 'rich-algo'),
            'use_featured_image'    => __('Use as featured image', 'rich-algo'),
            'insert_into_item'      => __('Insert into Algorithm', 'rich-algo'),
            'uploaded_to_this_item' => __('Uploaded to this Algorithm', 'rich-algo'),
            'items_list'            => __('Algorithms list', 'rich-algo'),
            'items_list_navigation' => __('Algorithms list navigation', 'rich-algo'),
            'filter_items_list'     => __('Filter Algorithms list', 'rich-algo'),
        ];
        $rewrite = [
            'slug'                  => 'algorithms',
            'with_front'            => true,
            'pages'                 => true,
            'feeds'                 => true,
        ];
        $args = [
            'label'               => __('Algorithm', 'rich-algo'),
            'description'         => __('Algorithms', 'rich-algo'),
            'labels'              => apply_filters('richweb_algorithm_labels', $labels),
            'supports'            => array('title', 'editor', 'excerpt', 'thumbnail', 'comments', 'custom-fields', 'publicize', 'wpcom-markdown'),
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_admin_bar'   => true,
            'show_in_nav_menus'   => true,
            'menu_position'       => 6,
            'menu_icon'           => 'dashicons-media-code',
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'capabilities'        => $this->capabilities(),
            'rewrite'             => $rewrite,
            'map_meta_cap'        => true,
            'query_var'           => true,
            'show_in_rest'        => true
        ];
        register_post_type('richweb_algorithm', apply_filters('richweb_algorithm_args', $args));
    }

    private function capabilities(): array
    {
        return [
            'edit_post'          => 'update_core',
            'read_post'          => 'update_core',
            'delete_post'        => 'update_core',
            'edit_posts'         => 'update_core',
            'edit_others_posts'  => 'update_core',
            'delete_posts'       => 'update_core',
            'publish_posts'      => 'update_core',
            'read_private_posts' => 'update_core'
        ];
    }
}
