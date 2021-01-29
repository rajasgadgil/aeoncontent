<?php

/**
 * Template Name: OceanWP Child Home Page
 *
 * @package OceanWP WordPress theme
 */

?>

<?php get_header(); ?>

<div class="top-section-wrapper">
  <section class="decision-making">
    <div class="box">
      <div class="left">
        <p class="one">Comprendre les enjeux, comparer les solutions et partenaires,</p>
        <p class="two">
          <span>
            <b>disposer de préconisations pour accélérer la prise de décision.</b></span>
        </p>
      </div>
      <div class="right">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/image/decision-making.png">
      </div>
    </div>
  </section>

  <section class="slider-main">
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
      <ol class="carousel-indicators">
        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
      </ol>
      <div class="carousel-inner">
        <div class="carousel-item active" style="background: url(<?php echo get_stylesheet_directory_uri(); ?>/assets/image/banner-one.png);">

        </div>
        <div class="carousel-item" style="background: url(<?php echo get_stylesheet_directory_uri(); ?>/assets/image/banner-one.png);">

        </div>
        <div class="carousel-item" style="background: url(<?php echo get_stylesheet_directory_uri(); ?>/assets/image/banner-one.png);">

        </div>
      </div>

    </div>
  </section>

  <section class="mini-slider">
    <div class="autoplay">

      <?php if (have_rows('small_slider_logo_and_text')) : ?>
        <?php while (have_rows('small_slider_logo_and_text')) : the_row();  ?>
          <div>
            <div class="wrapper">
              <div class="slider-image" style="background: url(<?php the_sub_field('small_slider_image'); ?>">
              </div>
              <h3><?php the_sub_field('small_slider_title'); ?></h3>
            </div>
          </div>
        <?php endwhile; ?>
      <?php endif; ?>
    </div>
  </section>
</div>

<section class="actualites">

  <div class="small-container">
    <?php
    $args = array('post_type' => 'news', 'posts_per_page' => 5, 'orderby' => 'ID');
    $the_query = new WP_Query($args);
    $totalNews = $the_query->post_count;
    ?>

    <?php $i = 0;
    if ($the_query->have_posts()) : ?>
      <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
        <?php $featured_img_url = get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>
        <?php if ($i == 0) { ?>
          <div class="detail">
            <div class="detail-box">
              <a href="<?php echo get_permalink( $post->ID ); ?>">
                <div class="banner" style="background: url(<?php echo $featured_img_url; ?>);">
                </div>
              </a>
              <div class="inner-wrapper">
                <h3><a href="<?php echo get_permalink( $post->ID ); ?>"><?php the_title(); ?></a></h3>
                <p><?php the_excerpt(); ?></p>
              </div>
            </div>
            <div class="box-details">
              <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/image/actualites.png">
              <h2>Actualités</h2>
              <p>You have just invested in a new vehicle, the one of your dreams, and you take it on a trip across Canada. You only put gas in it and drive sightseeing and following your nose. Filters and oil changes are ignored. The car breaks down in the middle of that long stretch of road between Manitoba and</p>
              <a href="#">Read More</a>
            </div>
          </div>
        <?php } else { ?>
          <?php if ($i == 1) { ?> <div class="list-items"> <?php } ?>
            <div class="wrapper">
              <a href="<?php echo get_permalink( $post->ID ); ?>">
                <div class="image-wrapper" style="background: url('<?php echo $featured_img_url; ?>')"></div>
              </a>
              <div class="details">
                <h3><a href="<?php echo get_permalink( $post->ID ); ?>"><?php the_title(); ?></a></h3>
                <p><?php the_excerpt(); ?></p>
              </div>
            </div>
            <?php if ($i == $totalNews) { ?> </div> <?php } ?>
        <?php } ?>
        <?php $i++; ?>
      <?php endwhile; ?>
    <?php endif; ?>
    <?php wp_reset_postdata(); ?>
  </div>
</section>

<section class="actualites type-two">

  <div class="small-container">
    <?php
    $args = array('post_type' => 'event', 'posts_per_page' => 5, 'orderby' => 'ID');
    $the_query = new WP_Query($args);
    $totalNews = $the_query->post_count;
    ?>

    <?php $i = 0;
    if ($the_query->have_posts()) : ?>
      <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
        <?php $featured_img_url = get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>
        <?php if ($i == 0) { ?>
          <div class="detail">
            <div class="detail-box">
              <a href="<?php echo get_permalink( $post->ID ); ?>">
                <div class="banner" style="background: url(<?php echo $featured_img_url; ?>);">
                </div>  
              </a>
              <div class="inner-wrapper">
                <h3><a href="<?php echo get_permalink( $post->ID ); ?>"><?php the_title(); ?></a></h3>
                <p><?php the_excerpt(); ?></p>
              </div>
            </div>
            <div class="box-details">
              <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/image/evenements.png">
              <h2>Evénements</h2>
              <p>You have just invested in a new vehicle, the one of your dreams, and you take it on a trip across Canada. You only put gas in it and drive sightseeing and following your nose. </p>
              <a href="#">Read More</a>
            </div>
          </div>
        <?php } else { ?>
          <?php if ($i == 1) { ?> <div class="list-items"> <?php } ?>
            <div class="wrapper">
              <a href="<?php echo get_permalink( $post->ID ); ?>">
                <div class="image-wrapper" style="background: url('<?php echo $featured_img_url; ?>')"></div>
              </a>
              <div class="details">
                <h3><a href="<?php echo get_permalink( $post->ID ); ?>"><?php the_title(); ?></a></h3>
                <p><?php the_excerpt(); ?></p>
              </div>
            </div>
            <?php if ($i == $totalNews) { ?> </div> <?php } ?>
        <?php } ?>
        <?php $i++; ?>
      <?php endwhile; ?>
    <?php endif; ?>
    <?php wp_reset_postdata(); ?>
  </div>
</section>

<section class="actualites">

  <div class="small-container">
    <?php
    $args = array('post_type' => 'article', 'posts_per_page' => 5, 'orderby' => 'ID');
    $the_query = new WP_Query($args);
    $totalNews = $the_query->post_count;
    ?>

    <?php $i = 0;
    if ($the_query->have_posts()) : ?>
      <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
        <?php $featured_img_url = get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>
        <?php if ($i == 0) { ?>
          <div class="detail">
            <div class="detail-box">
              <a href="<?php echo get_permalink( $post->ID ); ?>">
                <div class="banner" style="background: url(<?php echo $featured_img_url; ?>);">
                </div>
              </a>
              <div class="inner-wrapper">
                <h3><a href="<?php echo get_permalink( $post->ID ); ?>"><?php the_title(); ?></a></h3>
                <p><?php the_excerpt(); ?></p>
              </div>
            </div>
            <div class="box-details">
              <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/image/actualites.png">
              <h2>SIRH, une transformation humaine et culturelle</h2>
              <p>You have just invested in a new vehicle, the one of your dreams, and you take it on a trip across Canada. </p>
              <a href="#">Read More</a>
            </div>
          </div>
        <?php } else { ?>
          <?php if ($i == 1) { ?> <div class="list-items"> <?php } ?>
            <div class="wrapper">
              <a href="<?php echo get_permalink( $post->ID ); ?>">
                <div class="image-wrapper" style="background: url('<?php echo $featured_img_url; ?>')"></div>
              </a>
              <div class="details">
                <h3><a href="<?php echo get_permalink( $post->ID ); ?>"><?php the_title(); ?></a></h3>
                <p><?php the_excerpt(); ?></p>
              </div>
            </div>
            <?php if ($i == $totalNews) { ?> </div> <?php } ?>
        <?php } ?>
        <?php $i++; ?>
      <?php endwhile; ?>
    <?php endif; ?>
    <?php wp_reset_postdata(); ?>
  </div>
</section>

<section class="question">
  <div class="small-container">
    <h2>Qu’est-ce que Myteknow ?</h2>
    <h5>For Only Your Computer Usage Could Cost You Your Job
    </h5>
    <div class="detail-list">
      <div class="question-box">
        <div class="wrapper">
          <div class="image-wrapper" style="background: url(<?php echo get_stylesheet_directory_uri(); ?>/assets/image/question-image-one.png);"></div>
          <div class="details">
            <h3>Get The Boot A Birds Eye Look Into Mcse Boot Camps</h3>
            <p>Most people who work in an office environment, buy computer.
            </p>
          </div>
        </div>

        <div class="wrapper">
          <div class="image-wrapper" style="background: url(<?php echo get_stylesheet_directory_uri(); ?>/assets/image/question-image-two.png);"></div>
          <div class="details">
            <h3>Steps In Installing Rack Mount Lcd Monitors</h3>
            <p>Most people who work in an office environment, buy computer.
            </p>
          </div>
        </div>

        <div class="wrapper">
          <div class="image-wrapper" style="background: url(<?php echo get_stylesheet_directory_uri(); ?>/assets/image/question-image-three.png);"></div>
          <div class="details">
            <h3>Not All Blank Cassettes Are Created Equal</h3>
            <p>Most people who work in an office environment, buy computer.
            </p>
            </p>
          </div>
        </div>
      </div>
      <div class="link">
        <a href="#">Load More</a>
      </div>
    </div>
</section>




<?php get_footer(); ?>


