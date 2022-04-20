<?php
// Code adapted from Automattic, Inc, 2022
add_action('init', function() {
    remove_action('storefront_header', 'storefront_product_search', 40);
    remove_action('storefront_footer', 'storefront_handheld_footer_bar', 999);
    add_action('wp_enqueue_scripts', function() {
        $timestamp = time();
        $style_url = get_stylesheet_directory_uri() . '/Assets/CSS/style.css';
        wp_enqueue_style('rich-algo-theme-style', $style_url, [], $timestamp);
        $script_url = get_stylesheet_directory_uri() . '/Assets/JS/script.js';
        wp_enqueue_script('rich-algo-theme-script', $script_url, ['jquery'], $timestamp, true);
    });
});

add_action('algo_homepage', function() {
    while ( have_posts() ) {
        the_post();
        get_template_part('content','homepage');
    }
}, 10);

add_filter('wp_lazy_loading_enabled', '__return_false');
// end of adapted code
