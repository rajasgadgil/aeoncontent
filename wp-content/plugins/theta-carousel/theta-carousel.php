<?php
/*
Plugin Name: Theta Carousel
Plugin URI:  http://theta-carousel.com/wp
Description: Theta carousel is a WP plug-in that helps you quickly and easily organize your content in 3D space.
Version:     1.12
Author:      Theta Project
Author URI:  http://codecanyon.net/user/thetaproject
*/

if ( ! defined('ABSPATH') ) {
    die('Please do not load this file directly.');
}

define('THETA_CAROUSEL_PLUGIN_PATH', plugins_url('/', __FILE__));

require 'php/theta-carousel-admin.php';
require 'php/theta-carousel-client.php';

add_action('admin_enqueue_scripts', 'theta_carousel_register_admin_scripts', 999999);
add_action('init', 'theta_carousel_plugin_register');
add_action('add_meta_boxes', 'theta_carousel_add_meta_boxes');
add_action('save_post', 'theta_carousel_save_postdata');
add_action('post_row_actions', 'theta_carousel_row_actions', 10, 2);
add_filter('manage_theta_carousel_posts_columns', 'theta_carousel_modify_post_columns');
add_filter('manage_theta_carousel_posts_custom_column', 'theta_carousel_custom_column_content');