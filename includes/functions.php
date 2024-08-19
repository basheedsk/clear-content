<?php
// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

function cc_clear_pages() {
    $pages = get_pages();
    foreach ( $pages as $page ) {
        wp_delete_post( $page->ID, true );
    }
    echo '<div class="updated"><p>All pages have been successfully deleted.</p></div>';
}

function cc_clear_posts() {
    $posts = get_posts( array( 'numberposts' => -1 ) );
    foreach ( $posts as $post ) {
        wp_delete_post( $post->ID, true );
    }
    echo '<div class="updated"><p>All posts have been successfully deleted.</p></div>';
}

function cc_clear_themes() {
    $current_theme = wp_get_theme();
    $themes = wp_get_themes();
    foreach ( $themes as $theme_slug => $theme ) {
        if ( $theme_slug !== $current_theme->get_stylesheet() ) {
            switch_theme( $theme_slug );
            delete_theme( $theme_slug );
        }
    }
    switch_theme( $current_theme->get_stylesheet() );
    echo '<div class="updated"><p>All unactivated themes have been successfully deleted.</p></div>';
}

function cc_clear_media() {
    $media = get_posts( array( 'post_type' => 'attachment', 'numberposts' => -1 ) );
    foreach ( $media as $attachment ) {
        wp_delete_attachment( $attachment->ID, true );
    }
    echo '<div class="updated"><p>All media files have been thoroughly deleted.</p></div>';
}

function cc_clear_plugins() {
    $plugins = get_plugins();
    foreach ( $plugins as $plugin_file => $plugin ) {
        if ( ! is_plugin_active( $plugin_file ) ) {
            delete_plugins( array( $plugin_file ) );
        }
    }
    echo '<div class="updated"><p>All unactivated plugins have been successfully deleted.</p></div>';
}

function cc_uncheck_screen_options() {
    $user_id = get_current_user_id();
    $hidden_meta_boxes = array(
        'dashboard_activity',
        'dashboard_primary',
        'dashboard_quick_press',
        'dashboard_right_now',
        'dashboard_site_health',
        'dashboard_site_health',
        'dashboard_recent_drafts',
        'dashboard_recent_comments',
        'dashboard_incoming_links',
        'dashboard_plugins',
        'dashboard_secondary',
    );

    foreach ( $hidden_meta_boxes as $meta_box ) {
        update_user_meta( $user_id, 'metaboxhidden_dashboard', $hidden_meta_boxes );
    }

    // Hide the Welcome panel
    update_user_meta( $user_id, 'show_welcome_panel', 0 );
}
