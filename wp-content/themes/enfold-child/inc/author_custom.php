<?php
function teknow_author_create_db()
{
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    //* Create the teams table
    $table_name = $wpdb->prefix . 'teknow_author';
    $sql = "CREATE TABLE $table_name (
    author_id INTEGER NOT NULL AUTO_INCREMENT,
    post_id INTEGER NOT NULL,
    author_name TEXT NOT NULL,
    author_description TEXT NOT NULL,
    PRIMARY KEY (author_id)
    ) $charset_collate;";
    dbDelta($sql);
}
register_activation_hook(__FILE__, 'teknow_author_create_db');
