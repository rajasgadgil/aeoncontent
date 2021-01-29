<?php

/**
 * The template for displaying Tag pages
 *
 * Used to display archive-type pages for posts in a tag.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

get_header(); ?>
<?php 
     //displaying posts based on tags
     global $wp_query;
     $tag_id = get_queried_object()->term_id;
     $args = array(
            'post_type' => 'article', //must use post type for this field
             'tag_id' => $tag_id, //must use tag id for this field
             'post_status' => 'published',
             'posts_per_page' => -1,
             'order' => 'ASC'
         );
         $tag_posts = get_posts( $args );
         $query = new WP_Query( $args );
?>

<section class="search-2-title">
    <div class="container">
        <div class="row">

            <?php if(!empty($tag_posts) && is_array($tag_posts)): ?>

                <header class="archive-header">
                    <!-- <h1 class="archive-title"><?php //printf(__('Tag Archives: %s', 'pietergoosen'), single_tag_title('', false)); ?></h1> -->

                    <?php
                    // Show an optional term description.
                    $term_description = term_description();
                    if (!empty($term_description)) :
                        printf('<div class="taxonomy-description">%s</div>', $term_description);
                    endif;
                    ?>
                </header><!-- .archive-header -->

                <?php
                echo '<div class="tag--details"><div class="document-type-panels"><div id="all-panel" class="document-type-panel active">';
                foreach ( $tag_posts as $tag_post ) {                 
                    $display_name = get_the_author_meta( 'display_name' , $tag_post->post_author );
                    $tag_date = get_field('tag_date', $tag_post->ID);
                    $summary = get_field('summary', $tag_post->ID);
                    $detail = get_field('detail', $tag_post->ID);
                    $post_thumbnail_id = get_post_thumbnail_id( $tag_post->ID );
                   
                    ?>
                    <style type="text/css">
                        .tag--details .card-body {
                            display: grid;
                            gap: 20px;
                            grid-template-columns: 170px 1fr;
                            align-items: flex-start;
                            justify-content: flex-start;
                            border-bottom: 1px solid #ccc;
                        }
                        .tag--details .card {
                            border: 0px;
                        }
                    </style>
                        <div class="card mb-4">
                            <div class="card-body pt-0 pb-4 px-0">
                                <div class="d-flex align-items-center justify-content-center">
                                    <img src="<?= wp_get_attachment_image_src( $post_thumbnail_id, 'full' )[0]  ?>" class="feat-img" alt="<?= $tag_post->post_title ?>">
                                </div>
                                <div class="hc-lh-sm">
                                    <a href="<?= $tag_post->guid ?>">
                                        <h3 class="m-0 hc-fs-36 hc-fw-700 hc-color-primary">
                                        <?= $tag_post->post_title ?>
                                        </h3>
                                    </a>
                                    <span class="hc-fs-18 hc-fw-400"><?= $display_name?> | <?= date("F j, Y", strtotime($tag_post->post_date))  ?></span>
        
                                    <p class="card-text my-4 hc-lh-base">
                                    <?= $tag_post->post_excerpt ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php
                }                    
            else :
                // If no content, include the "No posts found" template.
                get_template_part('content', 'none');

            endif;
            ?>
        </div><!-- #content -->
    </div><!-- #content -->
</section><!-- #primary -->

<?php
get_sidebar('content');
get_footer();
?>