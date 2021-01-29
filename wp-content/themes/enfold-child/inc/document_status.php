<?php
////add_action('publish_article', 'wpse_send_rest_data', 10, 2);
//add_action('save_post_article', 'wpse_send_rest_data', 10, 2);

//add_action('save_post', 'wpse_send_rest_data', 9, 2);
function wpse_send_rest_data($post_ID, $post)
{
   // $url = 'https://kairos.blvckpixel.com/api/v1/import';
        $url = 'https://aeon.blvckpixel.com/api/v1/import';
    $arguments = array(
        'method' => 'GET'
    );
    wp_remote_get($url, $arguments);
}
add_action('publish_article', 'wpse_send_rest_data', 10, 2);
add_action('publish_news', 'wpse_send_rest_data', 10, 2);
add_action('publish_event', 'wpse_send_rest_data', 10, 2);

function wpse_send_rest_del_data($post_ID)
{
    //$url = 'https://kairos.blvckpixel.com/api/v1/import';
        $url = 'https://aeon.blvckpixel.com/api/v1/import';
    $arguments = array(
        'method' => 'GET'
    );
    wp_remote_get($url, $arguments);
}
add_action('trashed_post', 'wpse_send_rest_del_data', 10, 2);
