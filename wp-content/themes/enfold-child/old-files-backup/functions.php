<?php

/*
* Add your own functions here. You can also copy some of the theme functions into this file. 
* Wordpress will use those functions instead of the original functions then.
*/

add_action('after_setup_theme', 'my_theme_setup');
function my_theme_setup()
{
	load_child_theme_textdomain('teknow', get_stylesheet_directory() . '/languages');
}
add_filter('avf_masonry_loop_prepare', 'avf_masonry_loop_prepare_mod_cat', 10, 2);
function avf_masonry_loop_prepare_mod_cat($key, $entries)
{
	$categories = get_the_category($key['ID']);
	$separator = ' ';
	$date = get_the_date('d.m.y');


	$output = '
<div class="ww-masonry-cat">';
	if (!empty($categories)) {
		foreach ($categories as $category) {
			$output .= '<span>' . esc_html($category->name) . '</span>' . $separator;
		}
	}

	$output .= '</div>
';

	$key['text_before'] .= trim($output, $separator);
	return $key;
}






function oceanwp_child_enqueue_parent_style()
{
	// Dynamically get version number of the parent stylesheet (lets browsers re-cache your stylesheet when you update your theme)
	$theme   = wp_get_theme('OceanWP');
	$version = $theme->get('Version');
	// Load the stylesheet
	wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css', array('oceanwp-style'), $version);
	wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
	wp_enqueue_style('custom-doc', get_stylesheet_directory_uri() . '/css/style-doc.css');
	wp_enqueue_style('bootstrap', get_stylesheet_directory_uri() . '/assets/css/bootstrap.min.css');
	wp_enqueue_style('slick', get_stylesheet_directory_uri() . '/assets/css/slick.css');
	wp_enqueue_style('slick-theme', get_stylesheet_directory_uri() . '/assets/css/slick-theme.css');
	wp_enqueue_style('custom-style', get_stylesheet_directory_uri() . '/assets/css/style.css');
	wp_enqueue_style('custom-font', get_stylesheet_directory_uri() . '/assets/font/font.css');
	wp_enqueue_style('font-awesome', get_stylesheet_directory_uri() . '/assets/fonts/fontawesome/css/all.min.css', false, '5.15.1');

	wp_enqueue_script('jquery-custom', get_stylesheet_directory_uri() . '/js/jquery-3.5.1.min.js', array(), false, true);
	wp_enqueue_script('popper', get_stylesheet_directory_uri() . '/assets/js/popper.min.js', array('jquery-custom'), false, true);
	wp_enqueue_script('bootstrap', get_stylesheet_directory_uri() . '/assets/js//bootstrap.min.js', array('jquery-custom'), false, true);
	wp_enqueue_script('slick', get_stylesheet_directory_uri() . '/assets/js/slick.js', array('jquery-custom'), false, true);

	wp_enqueue_script('datatablejs', get_stylesheet_directory_uri() . '/assets/DataTables/datatables.min.js', array(), false, true);
	wp_enqueue_style('datatablecss', get_stylesheet_directory_uri() . '/assets/DataTables/datatables.min.css');
	wp_enqueue_script('customjs', get_stylesheet_directory_uri() . '/js/custom.js', array(), false, true);
	// wp_enqueue_script('search-engine', get_stylesheet_directory_uri() . '/js/search-engine.js', array('jquery-custom'), false, true);
	wp_enqueue_script('jquery-search-filter', get_stylesheet_directory_uri() . '/js/search-engine-filter.js', array(), false, true);
}
add_action('wp_enqueue_scripts', 'oceanwp_child_enqueue_parent_style');


define('THEME_URI', get_template_directory_uri());
define('THEME_PATH', get_template_directory());

// function tecknoew_include_jquery()
// {

//     wp_deregister_script('jquery');
//     //enqueuing th jquery and jquesy ui files
//     wp_enqueue_script('jquery ', THEME_URI . '/js/jquery-3.5.1.min.js', array(), '1.000');

//     add_action('wp_enqueue_scripts', 'jquery');
// }

// add_action('wp_enqueue_scripts', 'tecknoew_include_jquery');

// function invincix_scripts()
// {
//     //Theme css files

//     wp_enqueue_style('bootstrap-45', get_template_directory_uri() . '/css/bootstrap.min.css',  array(), false, 'all');


//     //Theme js files
//     wp_enqueue_script('bootstrap-js ', get_template_directory_uri() . '/js/bootstrap.min.js', array(), '1.000');
// }
/**
 * Register Custom Navigation Walker
 */
function register_navwalker()
{
	require_once get_stylesheet_directory() . '/class-wp-bootstrap-navwalker.php';
}
add_action('after_setup_theme', 'register_navwalker');
// add_action('wp_enqueue_scripts', 'invincix_scripts');
if (!file_exists(get_stylesheet_directory() . '/class-wp-bootstrap-navwalker.php')) {
	// File does not exist... return an error.
	return new WP_Error('class-wp-bootstrap-navwalker-missing', __('It appears the class-wp-bootstrap-navwalker.php file may be missing.', 'wp-bootstrap-navwalker'));
} else {
	// File exists... require it.
	require_once get_stylesheet_directory() . '/class-wp-bootstrap-navwalker.php';
}


//require_once get_stylesheet_directory() . '/inc/document_status.php';

add_filter('post_row_actions', 'remove_row_actions_post', 10, 2);
/*function remove_row_actions_post($actions, $post)
{
    if ($post->post_type === 'article' &&  $post->post_status == 'ready-for-review') {

        unset($actions['trash']);
    }
    if (($post->post_status === 'publish' && current_user_can('remove_edit_for_published_article')) || ($post->post_status === 'publication-review' && current_user_can('remove_integrator_edit__option'))) {
        unset($actions['edit']);
        unset($actions['inline hide-if-no-js']);
    }
    return $actions;
}*/
function remove_row_actions_post($actions, $post)
{
	$user = wp_get_current_user();
	if ((($post->post_type === 'article') || ($post->post_type === 'event') || ($post->post_type === 'news')) &&  $post->post_status == 'ready-for-review') {

		unset($actions['trash']);
		unset($actions['dpp']);
	}
	// if (($post->post_status === 'publish' && ($user->roles[0] === 'integrator' || $user->roles[0] === 'reviewer' )) || ($post->post_status === 'publication-review' && ($user->roles[0] === 'integrator' || $user->roles[0] === 'reviewer' ))) {
	// 	unset($actions['edit']);
	// 	unset($actions['dpp']);
	// 	unset($actions['inline hide-if-no-js']);
	// }
	if (($post->post_status === 'publish' && ($user->roles[0] === 'integrator' || $user->roles[0] === 'reviewer' ))) {
			unset($actions['edit']);
			unset($actions['dpp']);
			unset($actions['inline hide-if-no-js']);
		}

	// if ($post->post_status === 'publication-review' && ($user->roles[0] === 'integrator' || $user->roles[0] === 'reviewer' )) {
	// 	unset($actions['dpp']);
	// 	unset($actions['inline hide-if-no-js']);
	// }

	if ($post->post_status === 'publication-review' && ($user->roles[0] === 'integrator')) {
		unset($actions['edit']);
		unset($actions['dpp']);
		unset($actions['inline hide-if-no-js']);
	}

	if ($post->post_status === 'publication-review' && ($user->roles[0] === 'reviewer')) {
		unset($actions['dpp']);
		unset($actions['inline hide-if-no-js']);
	}


	return $actions;
}

add_action('admin_head', 'hide_edit_permalinks_admin_css');

function hide_edit_permalinks_admin_css()
{
	if (current_user_can('remove_integrator_publish_item') || current_user_can('remove_reviewer_publish_item')) {
?>
<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('#wp-admin-bar-publishpress_debug').remove();
		jQuery('#toplevel_page_pp-manage-roles').remove();
		jQuery('#menu-comments').remove();
		//temporary commenting for update button
		// jQuery('#publishing-action #publish').remove();
		// jQuery('#publishing-action').remove();
		jQuery(' #major-publishing-actions .clear').empty();
	});
</script>

<?php
	}
	if (current_user_can('remove_publisher_publish_item')) {
?>
<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('#wp-admin-bar-publishpress_debug').remove();
		// 				jQuery('#toplevel_page_pp-manage-roles').remove();
		jQuery('#toplevel_page_pp-manage-roles .pp-version-notice-upgrade-menu-item').remove();

	});
</script>

<?php
	}
	if (current_user_can('remove_article_add_new')) {
?>
<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('#page-title-action').remove();

	});
</script>

<?php
	}
}
/*function remove_add_new_button()
{
    if (current_user_can('remove_article_add_new')) {
        global $submenu;
        unset($submenu['edit.php?post_type=article'][10][0]);
        unset($submenu['edit.php?post_type=article'][10][1]);
        unset($submenu['edit.php?post_type=article'][10][2]);
    }
}
add_action('admin_menu', 'remove_add_new_button');*/


function teknow_add_custom_field_automatically($post_id)
{
	global $wpdb;
	$votes_count = get_post_meta($post_id, 'revision_count', true);
	$revision_count = (int)$votes_count + 1;
	update_post_meta($post_id, 'revision_count', $revision_count);
	$revisions = new WP_Query(array(
		'post_status'       => 'inherit',
		'post_type'         => 'revision',
		'posts_per_page'    => 1,
		'orderby'           => 'ID'
	));
	$lastRevisionID = array();
	$formatRevisions = array();
	if ($revisions->have_posts()) :
	while ($revisions->have_posts()) : $revisions->the_post();
	$lastRevisionID[] = get_the_ID() + 1;
	endwhile;
	endif;
	wp_reset_postdata();
	if (!empty($lastRevisionID)) {
		$formatRevisions = array('revision_id' => $lastRevisionID[0], 'revision_version' => $revision_count);
	} else {
		$formatRevisions = array('revision_id' => 1, 'revision_version' => $revision_count);
	}
	$getCustomRevisions = get_post_meta($post_id, 'custom_revisions');
	$parseRevisions = array();
	if (!empty($getCustomRevisions)) {
		$oldRevisions = $getCustomRevisions[0];
		$convertArr = (array)json_decode($oldRevisions);
		if (count($convertArr) > 0) {
			foreach ($convertArr as $key => $value) {
				$parseRevisions[] = (array)$value;
			}
			$parseRevisions[] = $formatRevisions;
		}
		update_post_meta($post_id, 'custom_revisions', json_encode($parseRevisions));
	} else {
		update_post_meta($post_id, 'custom_revisions', json_encode(array($formatRevisions)));
	}
}
add_action('publish_article', 'teknow_add_custom_field_automatically');


function display_custom_post_status_option()
{
	global $post;

	$user = wp_get_current_user();

	if (($post->post_type == 'article') || ($post->post_type == 'event')  || ($post->post_type == 'news')) {
		if ($user->roles[0] === 'integrator') {
			echo '<script>
            jQuery(window).on("load", function() {
                jQuery("select#post_status option").remove();
                jQuery("select#post_status").append("<option value=\"draft\">Draft</option><option value=\"ready-for-review\">Ready for Review</option>");
                 jQuery(".inline-edit-status select option").remove();
                jQuery(".inline-edit-status select").append("<option value=\"draft\">Draft</option><option value=\"ready-for-review\">Ready for Review</option>");
            }); </script>
            ';
		} else if ($user->roles[0] === 'reviewer') {
			echo '<script>
            jQuery(window).on("load", function() {
                jQuery("select#post_status option").remove();
               jQuery("select#post_status").append("<option value=\"draft\">Draft</option><option value=\"ready-for-review\" >Ready for Review</option><option value=\"publication-review\">Ready for Publish</option>");
               jQuery(".inline-edit-status select option").remove();
                jQuery(".inline-edit-status select").append("<option value=\"draft\">Draft</option><option value=\"ready-for-review\" >Ready for Review</option><option value=\"publication-review\">Ready for Publish</option>");
            });
            </script>
            ';
		} else if ($user->roles[0] == 'publisher') {
			echo '<script>
            jQuery(window).on("load", function() {
                jQuery("select#post_status option").remove();
                jQuery("select#post_status").append("<option value=\"draft\">Draft</option><option value=\"ready-for-review\" >Ready for Review</option><option value=\"publication-review\" >Ready for Publish</option><option value=\"publish\">Published</option>");
                jQuery(".inline-edit-status select option").remove();
                jQuery(".inline-edit-status select").append("<option value=\"draft\">Draft</option><option value=\"ready-for-review\" >Ready for Review</option><option value=\"publication-review\" >Ready for Publish</option><option value=\"publish\">Published</option>");

            });
            </script>
            ';
		}
	}
}
add_action('admin_footer', 'display_custom_post_status_option', 11);

function js_footer()
{
?>
<script>
	jQuery(document).ready(function() {
		jQuery(".apply-filter").click(function() {
			jQuery(".post-data-grid").css("display", "none");
			// jQuery(".pagination-box").css("display","none");
			var count = 0;
			jQuery("input[name='sector[]']:checked").each(function() {
				var id = jQuery(this).attr('id');
				jQuery("#" + id).css("display", "block");
				count++;
			});
			jQuery("input[name='author[]']:checked").each(function() {
				var id = jQuery(this).attr('id');
				jQuery("#" + id).css("display", "block");
				count++;
			});
			jQuery("input[name='tag[]']:checked").each(function() {
				var id = jQuery(this).attr('id');
				jQuery("#" + id).css("display", "block");
				count++;
			});
			// if(count >= 4){
			//    jQuery(".pagination-box").css("display","block"); 
			// }

		})
		jQuery(".filter_exapandable label").click(function() {
			console.log(jQuery(this));

			if (jQuery(this).hasClass('collapsed-closed')) {
				jQuery(this).removeClass('collapsed-closed');
				jQuery(this).addClass('collapsed-opened');

			} else if (jQuery(this).hasClass('collapsed-opened')) {
				jQuery(this).removeClass('collapsed-opened');
				jQuery(this).addClass('collapsed-closed');

			}
			if (jQuery(this).hasClass('icon-plus-expanded')) {
				jQuery(this).removeClass('icon-plus-expanded');
				jQuery(this).addClass('icon-minus-expanded');

			} else if (jQuery(this).hasClass('icon-minus-expanded')) {
				jQuery(this).removeClass('icon-minus-expanded');
				jQuery(this).addClass('icon-plus-expanded');

			}
			jQuery(this).parent().find("ul.sub-term").toggle();
		});
		jQuery(".sub-term li").click(function() {

			var count = 0;
			jQuery(this).parent().find('li').each(function(index, value) {

				if (jQuery(this).find('input').is(":checked")) {
					count++;
				}
			});

			if (count > 0) {
				jQuery(this).parent().parent().find('input.checkbox-term').attr("checked", "checked");
			} else {
				jQuery(this).parent().parent().find('input.checkbox-term').removeAttr("checked");
			}
		})
	});
</script>
<?php
}
add_action('wp_footer', 'js_footer');
// get taxonomies based on cpt
function get_terms_by_custom_post_type($post_type, $taxonomy)
{
	$args = array('post_type' => $post_type);
	$loop = new WP_Query($args);
	$postids = array();
	// build an array of post IDs
	while ($loop->have_posts()) : $loop->the_post();
	array_push($postids, get_the_ID());
	endwhile;
	// get taxonomy values based on array of IDs
	$regions = wp_get_object_terms($postids,  $taxonomy);
	return $regions;
}
// get site url
add_shortcode('cf7_siteurl', 'custom_siteurl', true);
function custom_siteurl()
{
	return get_site_url();
}
function change_dateformat($params, $content = null)
{

	$data = do_shortcode($content);
	$newDate = date("d/m/Y", strtotime($data));
	return $newDate;
}
add_shortcode('change_date_format', 'change_dateformat');
function change_timeformat($params, $content = null)
{
	setlocale(LC_TIME, "fr_FR");
	$data = do_shortcode($content);

	$newtime = strftime(" %T ", strtotime($data));
	return $newtime;
}
add_shortcode('change_time_format', 'change_timeformat');

function return_taxonomylist($taxonomy)
{

	$terms = get_terms(array(
		'taxonomy'   => $taxonomy,
		'hide_empty' => false,
		'parent' => 0,
	));
	if (!empty($terms) && is_array($terms)) {
		foreach ($terms as $term) {

?>
<li class="p-0 filter_exapandable">

	<input id="filter-<?= $taxonomy ?>-<?= $term->term_id ?>" type="checkbox" value="<?= $term->term_id ?>" name="<?= $taxonomy ?>[]" class="checkbox-term" />

	<?php
			$childterms = get_terms(array(
				'taxonomy'   => $taxonomy,
				'parent' => $term->term_id,
				'orderby' => 'slug',
				'hide_empty' => false
			));
								   // print_r($childterms);exit();
								   if (count($childterms) != 0) {
									   echo '<label class="filter-expandable-label icon-plus-expanded haschild">' . $term->name . '</label>';
									   echo '<ul class="sub-term collapsed-closed ">';
									   foreach ($childterms as $child) {
	?>
<li class="p-0">
	<label for="filter-<?= $taxonomy ?>-<?= $child->term_id ?>">
		<input id="filter-<?= $taxonomy ?>-<?= $child->term_id ?>" type="checkbox" value="<?= $child->term_id ?>" name="<?= $taxonomy ?>[]" />
		<?php echo $child->name; ?>
	</label>
	<?php
									   }
									   echo '</ul>';
								   } elseif (count($childterms) === 0) {
									   echo '<label class="filter-expandable-label">' . $term->name . '</label>';
								   }
	?>
</li>
<?php
								  }
	}
}

function event_shortcode()
{
	$events = get_posts(array('post_type' => 'event'));

	if (!empty($events) && is_array($events)) {
		echo '<div class="events page-summary">';
		foreach ($events as $event) {

			$display_name = get_the_author_meta('display_name', $event->post_author);
			$event_date = get_field('event_date', $event->ID);
			$summary = get_field('summary', $event->ID);
			$detail = get_field('detail', $event->ID);
			$announcement = get_field('announcement', $event->ID);
			$minutes = get_field('minutes', $event->ID);
			$post_thumbnail_id = get_post_thumbnail_id($event->ID);

?>
<div class="card page-summary-card mb-4">
	<div class="card-body pt-0 pb-4 px-0 d-flex">
		<div class="align-items-center justify-content-center">
			<img src="<?= wp_get_attachment_image_src($post_thumbnail_id, 'full')[0]  ?>" class="feat-                          img" alt="<?= $event->post_title ?>">
		</div>
		<div class="hc-lh-sm">
			<a href="<?= $event->guid ?>">
				<h3 class="m-0 hc-fs-36 hc-fw-700 hc-color-primary">
					<?= $event->post_title ?>
				</h3>
			</a>
			<span class="hc-fs-18 hc-fw-400"><?= $display_name ?> | <?= date("F j, Y", strtotime($event->post_date))  ?></span>
			<p class="card-text my-4 hc-lh-base">
				<?= $event->post_excerpt ?>
			</p>
			<div>
				<span class="hc-fs-18 text-uppercase">
					<p class="hc-color-secondary">
						<b>Event Detail:</b><br><br> <?= $detail ?>
					</p>
					<p class="hc-color-secondary">
						<b> Event Announcement:</b><br><br> <?= $announcement ?>
					</p>
				</span>
			</div>
		</div>
	</div>
</div>
<?php
		}
		echo '</div>';
	}
}
add_shortcode('get_all_events', 'event_shortcode');
// functions for pagination on news page.
function news_page_numeric_posts_nav()
{

	if (is_singular())
		return;

	global $wp_query;

	/** Stop execution if there's only 1 page */
	if ($wp_query->max_num_pages <= 1)
		return;

	$paged = get_query_var('paged') ? absint(get_query_var('paged')) : 1;
	$max   = intval($wp_query->max_num_pages);

	/** Add current page to the array */
	if ($paged >= 1)
		$links[] = $paged;

	/** Add the pages around the current page to the array */
	if ($paged >= 3) {
		$links[] = $paged - 1;
		$links[] = $paged - 2;
	}

	if (($paged + 2) <= $max) {
		$links[] = $paged + 2;
		$links[] = $paged + 1;
	}

	echo '<div class="navigation"><ul>' . "\n";

	/** Previous Post Link */
	if (get_previous_posts_link())
		printf('<li>%s</li>' . "\n", get_previous_posts_link());

	/** Link to first page, plus ellipses if necessary */
	if (!in_array(1, $links)) {
		$class = 1 == $paged ? ' class="active"' : '';

		printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link(1)), '1');

		if (!in_array(2, $links))
			echo '<li>…</li>';
	}

	/** Link to current page, plus 2 pages in either direction if necessary */
	sort($links);
	foreach ((array) $links as $link) {
		$class = $paged == $link ? ' class="active"' : '';
		printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link($link)), $link);
	}

	/** Link to last page, plus ellipses if necessary */
	if (!in_array($max, $links)) {
		if (!in_array($max - 1, $links))
			echo '<li>…</li>' . "\n";

		$class = $paged == $max ? ' class="active"' : '';
		printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link($max)), $max);
	}

	/** Next Post Link */
	if (get_next_posts_link())
		printf('<li>%s</li>' . "\n", get_next_posts_link());

	echo '</ul></div>' . "\n";
}


/* to support displaying custom post types */

add_theme_support('add_avia_builder_post_type_option');
add_theme_support('avia_template_builder_custom_post_type_grid');




/* to display advanced portfolio setting */

add_filter('avf_builder_boxes', 'enable_boxes_on_posts');
function enable_boxes_on_posts($boxes)
{
	$boxes[] = array('title' => __('Avia Layout Builder', 'avia_framework'), 'id' => 'avia_builder', 'page' => array('portfolio', 'page', 'post', 'article'), 'context' => 'normal', 'expandable' => true);
	$boxes[] = array('title' => __('Layout', 'avia_framework'), 'id' => 'layout', 'page' => array('portfolio', 'page', 'post', 'article'), 'context' => 'side', 'priority' => 'low');
	$boxes[] = array('title' => __('Additional Article Settings', 'avia_framework'), 'id' => 'preview', 'page' => array('portfolio', 'article'), 'context' => 'normal', 'priority' => 'high');

	return $boxes;
}



function avf_alb_supported_post_types_mod(array $supported_post_types)
{
	$supported_post_types[] = 'event';
	return $supported_post_types;
}
add_filter('avf_alb_supported_post_types', 'avf_alb_supported_post_types_mod', 10, 1);
function avf_metabox_layout_post_types_mod(array $supported_post_types)
{
	$supported_post_types[] = 'event';
	return $supported_post_types;
}
add_filter('avf_metabox_layout_post_types', 'avf_metabox_layout_post_types_mod', 10, 1);





function remove_menus()
{
	remove_menu_page('edit.php');
//	remove_menu_page('tools.php');
	remove_menu_page('admin.php?page=visualizer');
}

add_action('admin_menu', 'remove_menus');

function check_new_vs_update($post_id)
{
	$myPost   = get_post($post_id);
	$user = wp_get_current_user();
	$post_date  = new DateTime($myPost->post_date_gmt);
	$post_modified = new DateTime($myPost->post_modified_gmt);
	if ($user->roles[0] === 'publisher') {

		if (date_format($post_date, 'F j, Y') != get_the_date() && $myPost->post_type == 'article' && $myPost->post_status == 'publish') {
			$post->post_status = 'draft';
			wp_update_post($post);
		}
	}
}
add_action('save_post', 'check_new_vs_update');

/*remove search from header menu*/
add_filter('wp_nav_menu_items', 'avia_append_search_nav', 10, 2);

function avia_append_search_nav($items, $args)
{

	if ($args->theme_location == 'avia') {
		$search_form = get_search_form(false);
		$items = '<li id="menu-item-searchbox" class="fixed-element">' . $search_form . '' . $items;
	}
	return $items;
}
function event_shortcode_summant($atts, $content = null)
{
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	$args = array(
		'post_type' => $atts['type'],
		'posts_per_page' => 5,
		'paged' => get_query_var('paged') ?? 1
	);
	$the_query = new WP_Query($args);

	if ($the_query->have_posts()) :
	echo '<div class="events--details"><div class="events-type-panels"><div id="all-panel" class="events-type-panel active">';
	while ($the_query->have_posts()) : $the_query->the_post();
	
	

?>
<article class="event-entry " id="event-<?= the_ID() ?>">
	<div class="event-meta">
		<a href="<?= the_permalink() ?>" class="event-preview" title="<?= the_title() ?>">
			<img width="180" height="180" src="<?= the_post_thumbnail_url() ?>" class="wp-event-image" alt="">
		</a>
	</div>
	<div class="event-content">
		<div class="event-content-header">
			<h2 class="post-title event-title ">
				<a href="<?= the_permalink() ?>" rel="bookmark" title="<?= the_title() ?>">
					<?= the_title() ?>
					<span class="post-format-icon minor-meta"></span>
				</a>
			</h2>
			<span class="event-meta-infos">
				<span class="text-date">
					<?php if($atts['type'] == 'event'):?>
					 <?= get_field('occurence_date',get_the_ID()) ?>
					<?php else:?>
					<?= the_time('F j, Y') ?>
					<?php endif; ?>
				</span>
				<span class="text-sep text-sep-comment">/</span>
				<span class="event-author-link">

					by <?= the_author_posts_link() ?>

				</span>
			</span>
		</div>
		<div class="event-content-excerpt">
			<p><?= the_excerpt() ?></p>
		</div>
		<div class="event-read-more-link">
			<a href="<?= the_permalink() ?>" class="event-more-link">
				Lire la suite<span class="more-link-arrow"></span>
			</a>
		</div>
	</div>


</article>
<?php
		endwhile;
	$total_pages = $the_query->max_num_pages;

	if ($total_pages > 1) {
		$current_page = max(1, get_query_var('paged'));

		$paginate_links = paginate_links(array(
			'base'         => get_pagenum_link(1) . '%_%',
			'format' => 'page/%#%',
			'current' => $current_page,
			'total' => $total_pages,
			'end_size'     => 2,
			'mid_size'     => 3,
			'prev_next'    => True,
			'prev_text'    => __('«'),
			'next_text'    => __('»'),
		));

		print_r($paginate_links);
	} else {
		echo '<span aria-current="page" class="page-numbers current">3</span>';
		//echo '<span class="pagination-meta">Page sur </span>';
	}
	echo '<span class="pagination-meta">Page ' . $current_page . ' sur ' . $total_pages . '</span>';
	echo '</div></div></div>';
	endif;
}
add_shortcode('get_events_summary', 'event_shortcode_summant');

add_shortcode('get_event_listing','shortcode_event_listing');
function shortcode_event_listing($atts, $content = null){

$custom_post_type  = 'event';
$custom_date_field = 'occurence_date';
$order             = 'DESC'; // from the oldest to the newest

// query
$the_query = new WP_Query( [
    'post_type'      => $custom_post_type,
    'meta_key'       => $custom_date_field,
    'orderby'        => 'meta_value',
    'order'          => $order,
] );

// We are creating new multidimensional array
$all_events = [];
$year = [];
while ( $the_query->have_posts() ) :
    $the_query->the_post();

    $date       = strtotime( get_post_meta( get_the_ID(), $custom_date_field, true ) );
    $month_year = date( "F Y", $date );
   
    $all_events[ $month_year ][] = $the_query->post;

endwhile;
wp_reset_query();
// And to print this:
foreach ( $all_events as $month_year => $events ) : 
    $month_year_arr = explode(' ', $month_year);
    $month = $month_year_arr[0];
    $year = $month_year_arr[1];
    
    ?>
   <div class="events-card card col-xl-12 color col-md-12  mt-5" style="box-shadow: 0 5px 15px 0 rgba(32,39,48,.16); cursor: pointer;border: 1px solid rgba(0,0,0,.125);">
        <div class="card-body pl-xl-2 pr-xl-2 disabled ">
            <div class="row visibleonly1200 pb-3"><a id="inscription" name="inscription"> </a></div>
            <div class="row ">
                <div class="col-xl-2 col-lg-2 col-md-12 d-none d-xl-block ">
                    <hr align="left" class="mt-0" style="height: 2px; color: #3E4845; background-color: #3E4845; width: 70%; border: none;">
                    <a id="inscription" name="inscription"> </a>
                    <p style="color: #3E4845;line-height:25px; font-size:22px; font-weight: 700"><span class="month-style"><?= $month ?></span><br>
                        <?= $year ?>
                        </p>
                </div>
                <div class="col-xl-10 col-lg-10 col-md-12 d-none d-xl-block ">
                    
                    <?php 
                    /** @var \WP_Post $event */
                    foreach ( $events as $event ) : 
                        $image = wp_get_attachment_image_src( get_post_thumbnail_id( $event->ID ), 'single-post-thumbnail' )[0];?>
                        <div class="row ">
                            <div class="pr-3 pl-3 text-xl-center text-lg-left col-xl-3 d-none d-lg-block col-md-4 col-sm-12 col-lg-4 marge1400 ">
                            <img alt="Placeholder image" class="rounded height100" height="" src="<?= $image ?>" style="max-width: 230px">
                            </div>
                            <div class="col-xl offset-xl-0 mt-3 mt-lg-0 col-12 adaptationimage col-sm-12 col-lg-8 col-md-12 marge1200 pl-0 pl-lg-3">
                                <div class="row">
                                    <div class="col-xl-5 col-lg-5 col-md-4 col-sm-4 btn-group-vertical">

                                        <table border="0" cellpadding="0" cellspacing="0" class="text-center" style="background-color: #DFDFDF; color: #FFFFFF" width="130">
                                            <tbody>
                                                <tr>
                                                    <th class="py-1" scope="col" style="text-transform: uppercase; font-size:14px; color: #3E4845;">WEBINAIRE</th>
                                                </tr>
                                            </tbody>
                                        </table>
                                        
                                    </div>
                                    <div class="col-xl-7 border-right-0 col-lg-7 col-md-8 col-sm-8 mt-3 mt-sm-0" style="text-align: right">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                            <tbody>
                                                <tr>
                                                    <th class="text-left text-md-right text-xl-left pt-0" style="font-weight: 700; font-size: 15px">En partenariat avec&nbsp;</th>
                                                    <th class="text-right ml-1" width="135"><img alt="Placeholder image" src="https://cxp-prd-s3-cxp-statics.s3.eu-west-3.amazonaws.com/FR/Landing-Page/Webinars_2020/Ad+Ultima+Group_Logo.png" style="text-align: left;" width="130"></th>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <h5 class="card-title mt-3" style="line-height: 30px; font-weight: 400"><b>Transformer son SI pour accueillir l'industrie 4.0 </b></h5>
                                <hr align="left" class="mt-0" style="height: 1px; color: #3E4845; background-color: #C0C0C0; width: 30%; border: none;">
                                <div class="row">
                                    <div class="pl-2 col-12 offset-xl-0 offset-lg-0 col-lg-5 offset-md-0 col-md-4 col-xl-5 pl-3 text-md-center text-lg-left col-sm-5">
                                        <img alt="Placeholder image" class="mb-2 mr-2 calendrier-icon" height="25" src="https://cxp-prd-s3-cxp-statics.s3.eu-west-3.amazonaws.com/FR/Events_Images/Webinar_9_juillet_2020/Calendrier_picto.png"> 
                                        <span style="font-size: 14px; line-height:15px; color: #3E4845; font-weight: 400">Jeudi 28 janvier</span>
                                    </div>
                                    <div class="pl-2 col-12 col-lg-3 col-xl-3 col-sm-3 col-md-4 pl-3 text-md-center text-lg-left mt-3 mt-sm-1">
                                        <img alt="Placeholder image" class="mr-2 mb-1 horloge-icon" height="24" src="https://cxp-prd-s3-cxp-statics.s3.eu-west-3.amazonaws.com/FR/Events_Images/Webinar_9_juillet_2020/Horloge_picto.png">
                                        <span style="font-size: 14px; line-height:15px; color: #3E4845; font-weight: 400">9h</span>
                                    </div>
                                    <div class="pl-2 col-lg-4 col-12 offset-md-0 offset-sm-0 col-md-4 col-xl-4 mt-3 mt-sm-1 text-md-center text-lg-left col-sm-4 pl-3">
                                        <img alt="Placeholder image" class="mr-2 mb-1 picto-icon" height="22" src="https://cxp-prd-s3-cxp-statics.s3.eu-west-3.amazonaws.com/FR/Landing-Page/Webinars_2020/picto_webinar.png">
                                        <span style="font-size: 14px; line-height:15px; color: #3E4845; font-weight: 400">Online</span>
                                    </div>
                                </div>
                                <div class="row align-items-xl-end mt-4">
                                    <div class="col-sm-6 offset-xl-0 pl-sm-1 col-12 text-center text-sm-center text-lg-left col-xl-6 pl-lg-3"><a class="btn btn-primary pt-2 pb-2 taillebouton colorbutton" href="https://www.myteknow.com/pages/events/webinar-transformer-son-si-vers-industrie" target="_blank">Découvrir </a></div>
                                    <div class="col-sm-6 col-12 text-center text-sm-center text-lg-left mt-3 mt-sm-0 col-xl-6"><a class="btn btn-primary pt-2 pb-2 taillebouton colorbutton" href="https://register.gotowebinar.com/register/5321548725581002765" target="_blank">S'inscrire</a></div>
                                </div>
                            </div>

                        </div>
                        <hr class="text-center justify-content-xl-center align-self-xl-center" style="text-center" width="70%">
                    <?php endforeach; ?>
                   
                </div>
                
            </div>
        </div>
    </div>
<?php endforeach;
}
function css_footer()
{

	if (is_page(1471) || is_page(1307) || is_page(1689)) {
?>
<style>
	.stretch_full.container_wrap.alternate_color.light_bg_color.title_container {
		display: none;
	}

	.pp-multiple-authors-wrapper {
		display: none;
	}

	.entry-footer {
		display: none;
	}
	.comment-entry.post-entry {
		display: none;
	}
	.main_color.container_wrap_first.container_wrap.fullsize {
		border: none;
	}
</style>
<?php
	}
	if (is_single()) {
?>
<style>
	.stretch_full.container_wrap.alternate_color.light_bg_color.title_container {
		display: none;
	}

	.av-parallax.enabled-parallax.active-parallax.enabled-parallax {
		display: none;
	}
	
/* 	.pp-multiple-authors-wrapper {
		display: none;
	} */
	
	main.template-page.content.av-content-full.alpha.units {
		display: none;
	}
	footer.entry-footer {
		background: #fff;
	}
	.related_posts .wp-post-image{
		height: 145px;
		width: 145px;
	}
	.related_posts .related_entries_container {
		align-items: center;
		display: flex;
		justify-content: center;
	}
	.av-share-box h5.av-share-link-description.av-no-toc {
		font-size: 16px;
		line-height: 1.1em;
		font-weight: 600;
	}
	.related_posts h5.related_title {
		font-size: 16px;
		line-height: 1.1em;
		font-weight: 600;
	}
	/*.big-preview img {
	height: 413px;
	width: 1194px;
	}*/
</style>
<?php
	}
	global $post;
	if (is_single() && ($post->post_type == 'event')) {
?>
<style>
	.pp-multiple-authors-wrapper {
		display: none;
	}
	</style>
<?php
	}
}
add_action('wp_footer', 'css_footer');

/* DISABLE PUBLISH BUTTON FOR EVENTS */
function disable_publish_button_events(){

	$cpt_type = 'event';
	global $post;
	if($post->post_type == $cpt_type){
		echo '              
		<style>
                    #publish{
                        display:none!important;
                    }
#minor-publishing-actions div:nth-child(1) input{display: block!important;}

				#minor-publishing-actions{display: flex!important;
				flex-direction: column;
				text-align: left;
				}	
					#minor-publishing-actions input, #minor-publishing-actions a{width:  100%;}
                </style>

				';

	}	

	$ID = get_the_ID();

	if((get_post_status( $ID ) == 'publish')){
		echo '<style>

	         #publish{
                        display:block!important;
                    }
					
	</style>';

	}	


}
add_action('admin_head-post.php','disable_publish_button_events');
add_action('admin_head-post-new.php', 'disable_publish_button_events');



/* DISABLE PUBLISH BUTTON FOR NEWS */
function disable_publish_button_news(){

	$cpt_type = 'news';
	global $post;
	if($post->post_type == $cpt_type){
		echo '              
		<style>
                 #publish{
                        display:none!important;
                    }
					
#minor-publishing-actions div:nth-child(1) input{display: block!important;}

				#minor-publishing-actions{display: flex!important;
				flex-direction: column;
				text-align: left;
				}	
					#minor-publishing-actions input, #minor-publishing-actions a{width:  100%;}
                </style>
				';
	}
	$ID = get_the_ID();

	if((get_post_status( $ID ) == 'publish')){
		echo '<style>

	         #publish{
                        display:block!important;
                    }
	</style>';

	}	

}
add_action('admin_head-post.php','disable_publish_button_news');
add_action('admin_head-post-new.php', 'disable_publish_button_news');



/* DISABLE PUBLISH BUTTON FOR ARTICLES */
function disable_publish_button_articles(){

	$cpt_type = 'article';
	global $post;
	if($post->post_type == $cpt_type){
		echo '              
		<style>
                 #publish{
                        display:none!important;
                    }

				#minor-publishing-actions{display: flex!important;
				flex-direction: column;
				text-align: left;
				}	#minor-publishing-actions div:nth-child(1) input{display: block!important;}
					#minor-publishing-actions input, #minor-publishing-actions a{width:  100%;}
                </style>
				';

	}
	
		$ID = get_the_ID();

	if((get_post_status( $ID ) == 'publish')){
		echo '<style>

	         #publish{
                        display:block!important;
                    }
	</style>';

	}	

}
add_action('admin_head-post.php','disable_publish_button_articles');
add_action('admin_head-post-new.php', 'disable_publish_button_articles');










// gagan

add_action('wp_enqueue_scripts', 'add_custom_js');
function add_custom_js() {	
	wp_enqueue_style('bootstrap-select', get_stylesheet_directory_uri() . '/css/bootstrap-select.css');
	wp_enqueue_script('bootstrap-select', get_stylesheet_directory_uri() . '/js/bootstrap-select.js', array(), false, true);

}

add_action( 'init', 'verify_user_code' );
function verify_user_code(){
    if(isset($_GET['act'])){
        $data = unserialize(base64_decode($_GET['act']));
        $code = get_user_meta($data['id'], 'activation_code', true);
        // verify whether the code given is the same as ours
        if($code == $data['code']){
            // update the user meta
			update_user_meta($data['id'], 'account_activated', 1);
			redirect_to_login();
            //wc_add_notice( __( '<strong>Success:</strong> Your account has been activated! ', 'text-domain' )  );
        }
    }
}

function redirect_to_login(){
	$redirecturl = get_site_url();
	wp_redirect( $redirecturl . '/login/' );
	exit;
}
add_action( 'verify_user_code', 'redirect_to_login', 11 );


// end of code - gagan

/* Document versioning */

// setting a version slug
add_filter('wp_post_revision_meta_keys', 'wpse_track_slug_postmeta');

function wpse_track_slug_postmeta() {
    // Access the array of postmeta keys that is already versioned
    global $versionedKeys;

    // Add your custom postmeta key to the array
    $versionedKeys[] = 'versionedSlug';

    // Pass the array back to WordPress
    return $versionedKeys;
}

// custom save revision 
function wp_save_post_revision_custom( $post_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    $post = get_post( $post_id );
    if ( ! $post ) {
        return;
    }

    if ( ! post_type_supports( $post->post_type, 'revisions' ) ) {
        return;
    }

    if ( ! wp_revisions_enabled( $post ) ) {
        return;
    }

    
    $revisions = wp_get_post_revisions( $post_id );
    if ( $revisions ) {
        // Grab the last revision, but not an autosave.
        foreach ( $revisions as $revision ) {
            if ( false !== strpos( $revision->post_name, "{$revision->post_parent}-revision" ) ) {
                $last_revision = $revision;
                break;
            }
        }

        
        if ( isset( $last_revision ) && apply_filters( 'wp_save_post_revision_check_for_changes', true, $last_revision, $post ) ) {
            $post_has_changed = false;

            foreach ( array_keys( _wp_post_revision_fields( $post ) ) as $field ) {
                if ( normalize_whitespace( $post->$field ) !== normalize_whitespace( $last_revision->$field ) ) {
                    $post_has_changed = true;
                    break;
                }
            }

            $post_has_changed = (bool) apply_filters( 'wp_save_post_revision_post_has_changed', $post_has_changed, $last_revision, $post );

            // Don't save revision if post unchanged.
            if ( ! $post_has_changed ) {
                return;
            }
        }
    }

    $return = _wp_put_post_revision( $post );

    // If a limit for the number of revisions to keep has been set,
    // delete the oldest ones.
    $revisions_to_keep = wp_revisions_to_keep( $post );

    if ( $revisions_to_keep < 0 ) {
        return $return;
    }

    $revisions = wp_get_post_revisions( $post_id, array( 'order' => 'ASC' ) );

    $delete = count( $revisions ) - $revisions_to_keep;

    if ( $delete < 1 ) {
        return $return;
    }

    $revisions = array_slice( $revisions, 0, $delete );

    for ( $i = 0; isset( $revisions[ $i ] ); $i++ ) {
        if ( false !== strpos( $revisions[ $i ]->post_name, 'autosave' ) ) {
            continue;
        }

        wp_delete_post_revision( $revisions[ $i ]->ID );
    }

    return $return;
}
remove_action('pre_post_update', 'wp_save_post_revision');
remove_action( 'post_updated', 'wp_save_post_revision' );
add_action( 'post_updated', 'wp_save_post_revision_custom' );
//updating version slug for post updates
function check_update_revision_version( $post_id ){

//     remove_action('pre_post_update', 'wp_save_post_revision');
//     remove_action( 'post_updated', 'wp_save_post_revision' );
    
    $myPost   = get_post($post_id);
    $user = wp_get_current_user();

    wp_update_post( $post );
    //add_action( 'post_updated', 'wp_save_post_revision' );
	
    wp_save_post_revision_custom($post_id );
    $q = wp_get_post_revisions( $post_id );
   
    $count = count( $q );
	$count = $count-1 ;
    update_post_meta($post_id, 'versionedSlug', 'V'.$count);
    
}
add_action('save_post', 'check_update_revision_version' );

//Adding versions to permalink

add_filter( 'preview_post_link', 'custom_preview_post_link', 10, 2 );

function custom_preview_post_link( $link, \WP_Post $post )
{
    if(in_array($post->post_status, array('draft', 'ready-for-publish', 'ready-for-review' ))){
        $version = get_post_meta($post->ID, 'versionedSlug', true);
        $link = $link . "&v=".$version;
        
        return $link;
    } else{
        return $link;
    }
};
function display_revision()
{
    global $post;

    if (($post->post_type == 'article') || ($post->post_type == 'event')  || ($post->post_type == 'news')) {
        $q = wp_get_post_revisions( $post->ID );
        $version = get_post_meta($post->ID, 'versionedSlug', true);
        if (count($q) > 0  && $q ) {
             // $version = get_post_meta($post->ID, 'versionedSlug', true);
            echo '<script>
            jQuery(window).on("load", function() {
                 jQuery(".misc-pub-revisions b").remove();
                 jQuery("<b>'.$version.' </b> ").insertBefore(".misc-pub-revisions a");
            }); </script>
            ';
        } 
    }
}
add_action('admin_footer', 'display_revision', 11);

//change text
function change_revision_text( $translated_text, $text, $text_domain ) {

    $translated_text = str_ireplace( 'Revisions', 'Versions', $translated_text );
   
    return $translated_text;
}

add_filter ( 'gettext', 'change_revision_text',  20, 3);
/* End Document versioning */