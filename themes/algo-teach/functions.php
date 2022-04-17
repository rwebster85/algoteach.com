<?php

add_action('algo_homepage', 'storefront_homepage_content', 10);
add_action('algo_homepage', 'storefront_product_categories', 20);
add_action('algo_homepage', 'storefront_recent_products', 30);
add_action('algo_homepage', 'storefront_featured_products', 40);
add_action('algo_homepage', 'storefront_popular_products', 50);
add_action('algo_homepage', 'storefront_on_sale_products', 60);
add_action('algo_homepage', 'storefront_best_selling_products', 70);

add_action('init', function() {
    remove_action('storefront_header', 'storefront_product_search', 40);
    remove_action('storefront_footer', 'storefront_handheld_footer_bar', 999);
});

add_filter('wp_lazy_loading_enabled', '__return_false');


add_action('init', function() {
    add_action('wp_enqueue_scripts', function() {
        $timestamp = time();
        $style_url = get_stylesheet_directory_uri() . '/Assets/CSS/style.css';
        wp_enqueue_style('rich-algo-theme-style', $style_url, [], $timestamp);
    });
});
