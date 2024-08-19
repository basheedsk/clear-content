<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}


function clear_content_bulk_page_creation_menu() {
    add_submenu_page(
        'clear-content',
        'Bulk Page Creation',
        'Bulk Page Creation',
        'manage_options',
        'clear-content-bulk-page',
        'clear_content_bulk_page_creation_callback'
    );
}

function clear_content_bulk_page_creation_callback() {
    if (isset($_POST['bulk_create_pages'])) {
        $titles = explode("\n", sanitize_textarea_field($_POST['page_titles']));
        $parent_id = isset($_POST['parent_id']) ? intval($_POST['parent_id']) : 0;
        $template = isset($_POST['page_template']) ? sanitize_text_field($_POST['page_template']) : '';

        foreach ($titles as $title) {
            $title = trim($title);
            if (!empty($title)) {
                $page_data = array(
                    'post_title'    => $title,
                    'post_type'     => 'page',
                    'post_status'   => 'publish',
                    'post_parent'   => $parent_id,
                    'page_template' => $template,
                );
                wp_insert_post($page_data);
            }
        }
        echo '<div class="notice notice-success is-dismissible"><p>Pages created successfully!</p></div>';
    }
    ?>
    <div class="wrap">
        <h2>Bulk Page Creation</h2>
        <form method="post">
            <textarea name="page_titles" rows="10" cols="50" placeholder="Enter one title per line"></textarea>
            <p>
                <label for="parent_id">Parent Page (ID):</label>
                <input type="text" name="parent_id" id="parent_id">
            </p>
            <p>
                <label for="page_template">Page Template:</label>
                <input type="text" name="page_template" id="page_template">
            </p>
            <p>
                <input type="submit" name="bulk_create_pages" class="button-primary" value="Create Pages">
            </p>
        </form>
    </div>
    <?php
}
