<?php

/**
 * Template Name: Search result Page
 *
 * @package OceanWP WordPress theme
 */

?>

<?php get_header(); ?>

<section class="search-result-page">
  <div class="small-container">
    <div class="first-tab">
      <ul class="nav nav-pills first-section-tab">
        <li class="active"><a data-toggle="pill" href="#type" class="active">Type</a></li>
        <li><a data-toggle="pill" href="#author">Author</a></li>
      </ul>
      <article class="single-page-article clr">


        <div class="search-page-body">
          <ul class="nav nav-pills d-flex align-items-center justify-content-start document-type-tabs mb-5">
            <li class="nav-item flex-grow-1">
              <a class="nav-link d-block w-100 active text-center py-3" href="#all">All</a>
            </li>
            <li class="nav-item flex-grow-1">
              <a class="nav-link d-block w-100 text-center py-3" href="#articles">Articles</a>
            </li>
            <li class="nav-item flex-grow-1">
              <a class="nav-link d-block w-100 text-center py-3" href="#events">Events</a>
            </li>
            <li class="nav-item flex-grow-1">
              <a class="nav-link d-block w-100 text-center py-3" href="#news">News</a>
            </li>
            <li class="nav-item flex-grow-1">
              <a class="nav-link d-block w-100 text-center py-3" href="#softwares">Softwares</a>
            </li>
            <li class="nav-item flex-grow-1">
              <a class="nav-link d-block w-100 text-center py-3" href="#companies">Companies</a>
            </li>
          </ul>

          <div class="search-filters mb-5">
            <div class="d-flex align-items-center justify-content-start text-dark">
              <span class="item-count font-weight-bold"><span>0</span> Items found</span>
              <span class="search-sort ml-auto">Sort by <i class="fas fa-angle-down"></i></span>
            </div>
          </div>

          <div class="document-type-panels">
            <div id="all-panel" class="document-type-panel active"></div>
            <div id="articles-panel" class="document-type-panel">Articles</div>
            <div id="events-panel" class="document-type-panel">Events</div>
            <div id="news-panel" class="document-type-panel">News</div>
            <div id="softwares-panel" class="document-type-panel">Softwares</div>
            <div id="companies-panel" class="document-type-panel">Companies</div>
          </div>
        </div>


      </article>

    </div>
  </div>
</section>


<?php get_footer(); ?>