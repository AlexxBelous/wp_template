<?php
/*
|--------------------------------------------------------------------------
| REGISTER CUSTOM POST TYPE: MAIN BANNERS
|--------------------------------------------------------------------------
| Creates a custom post type for managing homepage banners.
| Supports title, content (WYSIWYG), and featured image.
| Intended for flexible banner management via admin panel.
*/
function novatheme_register_cpt_banners() {
    $labels = [
        'name'               => 'Main Banners',
        'singular_name'      => 'Main Banner',
        'add_new'            => 'Add New Banner',
        'add_new_item'       => 'Add New Banner',
        'edit_item'          => 'Edit Banner',
        'all_items'          => 'All Banners',
        'menu_name'          => 'Main Banners',
    ];

    $args = [
        'labels'             => $labels,
        'public'             => true,
        'has_archive'        => false,
        'menu_icon'          => 'dashicons-images-alt2',
        'supports'           => ['title', 'editor', 'thumbnail'],
        'show_in_rest'       => false,
    ];

    register_post_type('main_banner', $args);
}
add_action('init', 'novatheme_register_cpt_banners');


