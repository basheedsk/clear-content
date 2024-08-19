<?php
// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

function cc_create_menu() {
    add_menu_page(
        'Clear Content',
        'Clear Content',
        'manage_options',
        'clear-content',
        'cc_settings_page',
        'dashicons-trash',
        90
    );
}

function cc_settings_page() {
    $uncheck_screen_options = get_option( 'cc_uncheck_screen_options', false );
    ?>
    <div class="wrap">
        <h1><?php esc_html_e( 'Clear Content', 'clear-content' ); ?></h1>
        <form method="post" action="">
            <?php wp_nonce_field( 'cc_clear_content_nonce', 'cc_nonce_field' ); ?>
            <h2><?php esc_html_e( 'Clear Pages', 'clear-content' ); ?></h2>
            <p><input type="submit" name="cc_clear_pages" value="<?php esc_attr_e( 'Clear All Pages', 'clear-content' ); ?>" class="button button-danger"></p>
            <h2><?php esc_html_e( 'Clear Posts', 'clear-content' ); ?></h2>
            <p><input type="submit" name="cc_clear_posts" value="<?php esc_attr_e( 'Clear All Posts', 'clear-content' ); ?>" class="button button-danger"></p>
            <h2><?php esc_html_e( 'Clear Unactivated Themes', 'clear-content' ); ?></h2>
            <p><input type="submit" name="cc_clear_themes" value="<?php esc_attr_e( 'Clear Unactivated Themes', 'clear-content' ); ?>" class="button button-danger"></p>
            <h2><?php esc_html_e( 'Clear Media Files', 'clear-content' ); ?></h2>
            <p><input type="submit" name="cc_clear_media" value="<?php esc_attr_e( 'Clear All Media Files', 'clear-content' ); ?>" class="button button-danger"></p>
            <h2><?php esc_html_e( 'Clear Unactivated Plugins', 'clear-content' ); ?></h2>
            <p><input type="submit" name="cc_clear_plugins" value="<?php esc_attr_e( 'Clear Unactivated Plugins', 'clear-content' ); ?>" class="button button-danger"></p>
            <h2><?php esc_html_e( 'Manage Screen Options', 'clear-content' ); ?></h2>
            <p>
                <input type="checkbox" name="cc_uncheck_screen_options" value="1" <?php checked( 1, $uncheck_screen_options, true ); ?>>
                <?php esc_html_e( 'Uncheck all screen options in the dashboard', 'clear-content' ); ?>
            </p>
            <p><input type="submit" name="cc_save_settings" value="<?php esc_attr_e( 'Save Settings', 'clear-content' ); ?>" class="button button-primary"></p>
        </form>
    </div>
    <?php
}

function cc_handle_form_submission() {
    if ( isset( $_POST['cc_clear_pages'] ) && check_admin_referer( 'cc_clear_content_nonce', 'cc_nonce_field' ) ) {
        cc_clear_pages();
    }

    if ( isset( $_POST['cc_clear_posts'] ) && check_admin_referer( 'cc_clear_content_nonce', 'cc_nonce_field' ) ) {
        cc_clear_posts();
    }

    if ( isset( $_POST['cc_clear_themes'] ) && check_admin_referer( 'cc_clear_content_nonce', 'cc_nonce_field' ) ) {
        cc_clear_themes();
    }

    if ( isset( $_POST['cc_clear_media'] ) && check_admin_referer( 'cc_clear_content_nonce', 'cc_nonce_field' ) ) {
        cc_clear_media();
    }

    if ( isset( $_POST['cc_clear_plugins'] ) && check_admin_referer( 'cc_clear_content_nonce', 'cc_nonce_field' ) ) {
        cc_clear_plugins();
    }

    if ( isset( $_POST['cc_save_settings'] ) && check_admin_referer( 'cc_clear_content_nonce', 'cc_nonce_field' ) ) {
        $uncheck_screen_options = isset( $_POST['cc_uncheck_screen_options'] ) ? 1 : 0;
        update_option( 'cc_uncheck_screen_options', $uncheck_screen_options );
        if ( $uncheck_screen_options ) {
            cc_uncheck_screen_options();
        }
        echo '<div class="updated"><p>' . esc_html__( 'Settings saved.', 'clear-content' ) . '</p></div>';
    }
}
