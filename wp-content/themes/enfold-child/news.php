<?php

/**
 * Template Name: News Page
 *
 * @package OceanWP WordPress theme
 */

?>

<?php get_header(); 
    $our_current_page = get_query_var( 'paged' );
    // echo $our_current_page;
    // echo 'i am here';
    $posts_per_page = get_option('posts_per_page');
    echo $posts_per_page;
    $query = new \WP_Query(
        [
           'post_type'              => array('news'),
           'post_status'            => 'publish',
           'posts_per_page'         => get_option('posts_per_page'),
           'paged'                  => $our_current_page,
           'update_post_meta_cache' => false,
           'update_post_term_cache' => false,
        ]
     );
     echo $query->max_num_pages;
    //  print_r($query);
    /**
 * Custom pagination
 */
function custom_pagination( $query ) {

    $allowed_tags = [
       'span' => [
          'class' => [],
       ],
       'i'    => [
          'class' => [],
       ],
       'a'    => [
          'class' => [],
          'href'  => [],
       ],
    ];
 
    printf(
       '<nav class="ninetrade-pagination clearfix">%s</nav>',
       wp_kses(
          paginate_links(
             [
                'prev_text' => '<i class="fa fa-angle-left" aria-hidden="true"></i> ' . __( 'Previous', 'ninetrade' ),
                'next_text' => __( 'Next', 'ninetrade' ) . ' <i class="fa fa-angle-right" aria-hidden="true"></i>',
                'format' => '?paged=%#%',
                'current' => max( 1, get_query_var('paged')),
                'total'     => $query->max_num_pages
             ]
          ),
          $allowed_tags
       )
    );
 }

?>
<div class="small-container">
<h2 class="feat-img">Nouvelles</h2>
<div id="news-panel" class="document-type-panel" style="display: block;">
    <?php
            $news = get_posts(array('post_type' => 'news'));
            if(!empty($news) && is_array($news)){
                echo '<div class="news--details"><div class="document-type-panels"><div id="all-panel" class="document-type-panel active">';
                foreach ( $news as $news_n ) {                  
                    $display_name = get_the_author_meta( 'display_name' , $news_n->post_author );
                    $news_date = get_field('news_date', $news_n->ID);
                    $summary = get_field('summary', $news_n->ID);
                    $detail = get_field('detail', $news_n->ID);
                    $post_thumbnail_id = get_post_thumbnail_id( $news_n->ID );
                   
                    ?>
                    <style type="text/css">
                        .news--details .card-body {
                            display: grid;
                            gap: 20px;
                            grid-template-columns: 170px 1fr;
                            align-items: flex-start;
                            justify-content: flex-start;
                            border-bottom: 1px solid #ccc;
                        }
                        .news--details .card {
                            border: 0px;
                        }
                    </style>
                        <div class="card mb-4">
                            <div class="card-body pt-0 pb-4 px-0">
                                <div class="d-flex align-items-center justify-content-center">
                                    <img src="<?= wp_get_attachment_image_src( $post_thumbnail_id, 'full' )[0]  ?>" class="feat-img" alt="<?= $news_n->post_title ?>">
                                </div>
                                <div class="hc-lh-sm">
                                    <a href="<?= $news_n->guid ?>">
                                        <h3 class="m-0 hc-fs-36 hc-fw-700 hc-color-primary">
                                        <?= $news_n->post_title ?>
                                        </h3>
                                    </a>
                                    <span class="hc-fs-18 hc-fw-400"><?= $display_name?> | <?= date("F j, Y", strtotime($news_n->post_date))  ?></span>
        
                                    <p class="card-text my-4 hc-lh-base">
                                    <?= $news_n->post_excerpt ?>
                                    </p>
                                    <div>
                                        <span class="hc-fs-18 text-uppercase">
                                            <a href="<?= $news_n->guid ?>">READ MORE</a>  
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                }
                 echo '</div></div></div>';
            }
    ?>
            </div>
</div>
<?php 
    custom_pagination( $query );
get_footer(); ?>