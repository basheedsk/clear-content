<?php
/**
 * Plugin Name: Clear Content
 * Description: A versatile plugin to delete all pages, posts, unactivated themes, media files, unactivated plugins, and manage screen options.
 * Version: 1.4
 * Author: Basheed
 * Text Domain: clear-content
 * License: MIT
 * License URI: https://opensource.org/licenses/MIT
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Define plugin constants
define( 'CC_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'CC_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// Include necessary files
require_once CC_PLUGIN_DIR . 'includes/functions.php';
require_once CC_PLUGIN_DIR . 'includes/admin-settings.php'; 
require_once CC_PLUGIN_DIR . 'includes/bulk-page.php';




// Hook into WordPress
add_action( 'admin_menu', 'cc_create_menu' );
add_action( 'admin_init', 'cc_handle_form_submission' );
add_action( 'admin_enqueue_scripts', 'cc_enqueue_admin_styles' );

// Hook for the bulk page creation menu
add_action('admin_menu', 'clear_content_bulk_page_creation_menu');

function cc_enqueue_admin_styles() {
    wp_enqueue_style( 'cc-admin-styles', CC_PLUGIN_URL . 'assets/css/admin-styles.css' );
}
