<?php get_header(); ?>


<?php
if ( !defined('ABSPATH') ){ die(); }

global $avia_config;


get_header();

//	allows to customize the layout
do_action( 'ava_search_after_get_header' );


$results = avia_which_archive();
echo avia_title(array('title' => $results ));

do_action( 'ava_after_main_title' );
?>

<div class='container_wrap container_wrap_first main_color <?php avia_layout_class( 'main' ); ?>'>

<div class='container'>

<main class='content template-search <?php avia_layout_class( 'content' ); ?> units' <?php avia_markup_helper(array('context' => 'content'));?>>

<?php
if(!empty($_GET['s']) || have_posts())
{ 

echo "<h4 class='extra-mini-title widgettitle'>{$results}</h4>";

/* Run the loop to output the posts.
* If you want to overload this in a child theme then include a file
* called loop-search.php and that will be used instead.
*/

get_template_part( 'includes/loop', 'search' );

}?>


<!--end content-->
</main>

<?php

//get the sidebar
$avia_config['currently_viewing'] = 'page';

get_sidebar();

?>

</div><!--end container-->

</div><!-- close default .container_wrap element -->




<?php 
get_footer();