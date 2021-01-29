<?php

function theta_carousel_register_admin_scripts() {
	$screen = get_current_screen();

	if ($screen->post_type == 'theta_carousel') {
		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-ui-widget' );
		wp_enqueue_script( 'jquery-ui-sortable' );
		wp_enqueue_script( 'jquery-ui-tabs' );

		$wp_scripts = wp_scripts();
		wp_enqueue_style('theta_carousel-admin-ui-css',
                'http://ajax.googleapis.com/ajax/libs/jqueryui/'.$wp_scripts->registered['jquery-ui-core']->ver.'/themes/smoothness/jquery-ui.css');

		wp_enqueue_script( 'underscore' );
		
		wp_enqueue_media();

		wp_register_script('theta-carousel-admin-script', THETA_CAROUSEL_PLUGIN_PATH.'js/admin.js', array( 'jquery-ui-core', 'jquery-ui-widget' ));
		wp_enqueue_script('theta-carousel-admin-script');

		wp_register_style('theta-carousel-css', THETA_CAROUSEL_PLUGIN_PATH.'css/theta-carousel.css');
		wp_enqueue_style('theta-carousel-css');

		wp_register_style('theta-carousel-common-css', THETA_CAROUSEL_PLUGIN_PATH.'css/theta-carousel-common.css');
		wp_enqueue_style('theta-carousel-common-css');
	}
}

function theta_carousel_plugin_register () {
	$labels = array(
		'name' => esc_html__('Theta Carousels', 'theta_carousel'),
		'singular_name' => esc_html__('Theta Carousel', 'theta_carousel'),
		'menu_name' => esc_html__('Theta Carousels', 'theta_carousel'),
		'add_new' => esc_html__('New Carousel', 'theta_carousel'),
		'add_new_item' => esc_html__('New Carousel', 'theta_carousel'),
		'edit_item' => esc_html__('Edit Carousel', 'theta_carousel'),
		'new_item' => esc_html__('New Carousel', 'theta_carousel'),
		'view_item' => esc_html__('View Carousel', 'theta_carousel'),
		'not_found' => esc_html__('No carousels found', 'theta_carousel'),
		'not_found_in_trash' => esc_html__('No carousels found in Trash', 'theta_carousel'),
	);
	$args = array(
		'labels' => $labels,
		'description' => esc_html__('Theta Carousel - 3D', 'theta_carousel'),
		'public' => false,
		'exclude_from_search' => true,
		'publicly_queryable' => false,
		'show_ui' => true,
		'show_in_nav_menus' => false,
		'show_in_menu' => true,
		'menu_position' => 10,
		'menu_icon' => 'dashicons-images-alt2',
		'hierarchical' => false,
		'supports' => array('title'),
		'has_archive' => false,
		'query_var' => false,
		'can_export' => true,
		'rewrite' => true,
		'capability_type' => 'post'
	);
	register_post_type('theta_carousel', $args);
}

function theta_carousel_modify_post_columns($columns) {
	// new columns to be added
	$new_columns = array(
		'shortcode' => esc_html__('Shortcode', 'theta_carousel')
	);
	$columns = array_slice($columns, 0, 2, true) + $new_columns + array_slice($columns, 2, NULL, true);
	return $columns;
}

function theta_carousel_custom_column_content($column) {
	
	global $post;

	if ($column == 'shortcode') {
		$shortcode = "[theta-carousel id='".$post->ID."']";
		echo esc_html($shortcode);
	}
}

function theta_carousel_row_actions($actions, $post) {
	if ($post->post_type == 'theta_carousel') {
		unset($actions['inline hide-if-no-js']);
	}
	return $actions;
}

function theta_carousel_add_meta_boxes() {
	global $post;

	add_meta_box('theta_carousel', esc_html__('Theta Carousel'), 'theta_carousel_content', 'theta_carousel', 'normal', 'high');
}

function theta_carousel_content($post) {
	$slides = get_post_meta($post->ID, 'theta_carousel_slides', true);
	$config = get_post_meta($post->ID, 'theta_carousel_config', true);
	$adminView = get_post_meta($post->ID, 'theta_carousel_admin_view', true);
	
	echo "<div id='theta_settings'>";
		echo "<input type='hidden' id='theta_carousel_slides' name='theta_carousel_slides' value='".esc_attr($slides)."'>";
		echo "<input type='hidden' id='theta_carousel_config' name='theta_carousel_config' value='".esc_attr($config)."'>";
		echo "<input type='hidden' id='theta_carousel_id' disabled name='theta_carousel_id' value='".esc_attr($post->ID)."'>";
		echo "<input type='hidden' id='plugin_dir_url' disabled name='plugin_dir_url' value='".plugin_dir_url(__FILE__)."'>";
		echo "<input type='hidden' id='theta_carousel_admin_view' name='theta_carousel_admin_view' value='".esc_attr($adminView)."'>";
		
	echo "</div>";
	echo "<script type='text/javascript'>\n";
		echo "jQuery(document).ready(function() {\n";
		echo "	jQuery('#theta_settings').wp_carousel_config();\n";
		echo "});\n";
	echo "</script>\n";
}

function theta_carousel_save_postdata($postId) {

	if(isset($_POST["theta_carousel_slides"]))
		update_post_meta($postId, "theta_carousel_slides", sanitize_text_field($_POST["theta_carousel_slides"]));
	if(isset($_POST["theta_carousel_config"]))
		update_post_meta($postId, "theta_carousel_config", sanitize_text_field($_POST["theta_carousel_config"]));
	if(isset($_POST["theta_carousel_admin_view"]))
		update_post_meta($postId, "theta_carousel_admin_view", sanitize_text_field($_POST["theta_carousel_admin_view"]));
}

?>