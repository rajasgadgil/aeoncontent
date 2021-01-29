<?php
	if ( ! defined('ABSPATH') ){ die(); }
	
	global $avia_config;
	
	$lightbox_option = avia_get_option( 'lightbox_active' );
	$avia_config['use_standard_lightbox'] = empty( $lightbox_option ) || ( 'lightbox_active' == $lightbox_option ) ? 'lightbox_active' : 'disabled';

	/**
	 * Allow to overwrite the option setting for using the standard lightbox
	 * Make sure to return 'disabled' to deactivate the standard lightbox - all checks are done against this string
	 * 
	 * @added_by Günter
	 * @since 4.2.6
	 * @param string $use_standard_lightbox				'lightbox_active' | 'disabled'
	 * @return string									'lightbox_active' | 'disabled'
	 */
	$avia_config['use_standard_lightbox'] = apply_filters( 'avf_use_standard_lightbox', $avia_config['use_standard_lightbox'] );

	$style 					= $avia_config['box_class'];
	$responsive				= avia_get_option( 'responsive_active' ) != 'disabled' ? 'responsive' : 'fixed_layout';
	$blank 					= isset( $avia_config['template'] ) ? $avia_config['template'] : '';	
	$av_lightbox			= $avia_config['use_standard_lightbox'] != 'disabled' ? 'av-default-lightbox' : 'av-custom-lightbox';
	$preloader				= avia_get_option( 'preloader' ) == 'preloader' ? 'av-preloader-active av-preloader-enabled' : 'av-preloader-disabled';
	$sidebar_styling 		= avia_get_option( 'sidebar_styling' );
	$filterable_classes 	= avia_header_class_filter( avia_header_class_string() );
	$av_classes_manually	= 'av-no-preview'; /*required for live previews*/
	
	/**
	 * If title attribute is missing for an image default lightbox displays the alt attribute
	 * 
	 * @since 4.7.6.2
	 * @param bool
	 * @return false|mixed			anything except false will activate this feature
	 */
	$mfp_alt_text = false !== apply_filters( 'avf_lightbox_show_alt_text', false ) ? 'avia-mfp-show-alt-text' : '';

	/**
	 * Allows to alter default settings Enfold-> Main Menu -> General -> Menu Items for Desktop
	 * @since 4.4.2
	 */
	$is_burger_menu = apply_filters( 'avf_burger_menu_active', avia_is_burger_menu(), 'header' );
	$av_classes_manually   .= $is_burger_menu ? ' html_burger_menu_active' : ' html_text_menu_active';

	/**
	 * Add additional custom body classes
	 * e.g. to disable default image hover effect add av-disable-avia-hover-effect
	 * 
	 * @since 4.4.2
	 */
	$custom_body_classes = apply_filters( 'avf_custom_body_classes', '' );

	/**
	 * @since 4.2.3 we support columns in rtl order (before they were ltr only). To be backward comp. with old sites use this filter.
	 */
	$rtl_support = 'yes' == apply_filters( 'avf_rtl_column_support', 'yes' ) ? ' rtl_columns ' : '';
	
	
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="<?php echo "html_{$style} {$responsive} {$preloader} {$av_lightbox} {$filterable_classes} {$av_classes_manually}" ?> ">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<?php

/*
 * outputs a rel=follow or nofollow tag to circumvent google duplicate content for archives
 * located in framework/php/function-set-avia-frontend.php
 */
 if( function_exists( 'avia_set_follow' ) ) 
 { 
	 echo avia_set_follow();
 }

?>


<!-- mobile setting -->
<?php

$meta_viewport = ( strpos( $responsive, 'responsive' ) !== false ) ?  '<meta name="viewport" content="width=device-width, initial-scale=1">' : '';

/**
 * @since 4.7.6.4
 * @param string
 * @return string
 */
echo apply_filters( 'avf_header_meta_viewport', $meta_viewport );

?>
<style type="text/css" id="wp-custom-css">
			/* GLOBAL STYLES */
#top .av-subheading_above{
	text-transform: uppercase;
  letter-spacing: .2em;
  color: #f46a1b;}
#top #header_meta{
	background:#0d315e!important;
  border:none!important;}
#top .avia-search-tooltip{
	  background: transparent;
    border: none;
    box-shadow: none;
    width: 400px;
    margin-left: -100px;
		margin-top:10px}
#top .avia-search-tooltip input[type="text"]{
    border-radius: 100px;
    padding-left: 20px!important;
		box-shadow: 0 0 20px rgba(0,0,0,.4);}
#top .avia-search-tooltip input[type="submit"]{
	    border-top-right-radius: 100px!important;
    border-bottom-right-radius: 100px!important;}
#top .avia-search-tooltip .avia-arrow-wrap,
#top .ajax_search_response h4{
	display:none;}
#top .av_ajax_search_entry{
	background: white!important;
	margin-right: -15px;}
#top .av_ajax_search_entry:hover {
	background-color: #fafafa!important;}
#footer .first .widget_media_image{
	margin-bottom:0;
	text-align: center;}
#footer .first .widget_custom_html{
	margin-top:0;}
#footer .pm-footersocial{
	display: flex;
	justify-content: center;}
#footer .pm-footersocial a{
	margin:0 10px;}
#footer .pm-footersocial a img{
	  filter: saturate(0) brightness(0);
    opacity: .4;
	transition:all .3s ease-in-out}
#footer .pm-footersocial a:hover img{
	  filter: saturate(.8);
    opacity: 1;}
#footer h3{
	letter-spacing:0!important;}


/* HOMEPAGE STYLES */
#pm-home{
	border-bottom: 3px solid #ec6930!important;}
#pm-home .av-section-color-overlay,
#pm-sectorposts .av-section-color-overlay,
#pm-contact .av-section-color-overlay{
	background-repeat: no-repeat;
  background-size: cover;}
#pm-home .avia_textblock p{
	margin-bottom:0;}
#pm-home #pm-featuredicons{
	display: flex;
  justify-content: space-between;
  padding-top:20px;
  padding-bottom:20px;}
#pm-home #pm-featuredicons > a{
	border:none;
  padding-left:0;
  text-align:left;}
#pm-home #pm-featuredicons > a .avia_button_icon{
	border-radius: 100%;
  background: rgb(8,39,78,.6);
  display: inline-block;
	padding: 10px;}
#pm-home #pm-featuredicons > a .avia_button_icon::before{	
  font-size: 20px;
  width: 20px;
  height: 20px;
	padding: 0 2px;
  padding-top: 4px;
  display:inline-block}
#pm-home #pm-featuredicons .avia_iconbox_title{
	  font-weight: 500;
    letter-spacing: .03em;
    font-size: 12px;}
#pm-home .avia-caption-title,
#pm-home .avia-caption-content p{
	background:transparent;}
#pm-home .avia-caption-title{
	color:white!important;}
#pm-home .avia-caption-content p{
color:rgba(255,255,255,.6)!important;} 
#pm-home .avia-caption-title span{
	   font-family: arial;
    font-size: 15px;
    display: block;
    text-transform: uppercase;
    letter-spacing: .2em;
    color: #f46a1b;
    font-weight: 100;}
#top #pm-home #pm-doublebutton .avia-button{
	text-decoration:none}
#pm-homesectors .pm-roundedcorner .avia-image-container-inner{
		    box-shadow: 0 0 20px rgba(0,0,0,.4)!important;
    border-radius: 10px;
    overflow: hidden;}
#pm-homesectors .tc-button{
	background:transparent;
  margin-top: -30px;}
#pm-homesectors .tc-button:hover{
	color:#f46B1B;}
#pm-services .av-masonry,
#pm-sectorposts .av-masonry{
	overflow:visible;}
#pm-services .av-masonry .avia-arrow, 
#pm-sectorposts .av-masonry .avia-arrow{
	display:none;}
#pm-services .av-masonry .av-inner-masonry,
#pm-sectorposts .av-masonry .av-inner-masonry{
	border-radius:10px;}
#pm-services .av-masonry .av-inner-masonry-content,
#pm-sectorposts .av-masonry .av-inner-masonry-content{
background:rgba(255,255,255,.2);
  background: linear-gradient(189deg, rgba(255,255,255,0) 0%, rgba(255,255,255,1) 100%);}
#pm-services .av-masonry .ww-masonry-cat span,
#pm-sectorposts .av-masonry .ww-masonry-cat span{
	  text-transform: uppercase;
    font-size: 11px;
    letter-spacing: .2em;
    color: white;
    background: #f46a1b;
    padding: 2px 10px;
    margin-bottom: 10px;
	display: inline-block;}
#pm-services .av-masonry .av-masonry-entry-title,
#pm-sectorposts .av-masonry .av-masonry-entry-title{
	font-size:24px;
  color:#003E7D}
#pm-services .av-masonry .av-inner-masonry,
#pm-sectorposts .av-masonry .av-inner-masonry{
	box-shadow: 0 0 20px rgba(0,0,0,.4)!important;}
#pm-about .avia-logo-grid .avia-smallarrow-slider-heading,
#pm-about .slide-meta{
	display:none;}

/* LANDING PAGE STYLES */
#pm-sectorintro #pm-nomargin{
	margin-top:0;}
#pm-sectorintro #pm-sectorimage{
	margin-top:.85em;}
#pm-sectorintro #pm-sectorimage .avia-image-container {
	  border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 0 20px rgba(0,0,0,.4);}
#pm-sectorintro .toggle_icon,
#pm-sectorintro .vert_icon,
#pm-sectorintro .hor_icon{
	border-color: #f46B1B;}
#pm-sectorintro .toggle_content.invers-color {
	background-color:#fafafa;}
#pm-sectorteam .avia-image-overlay-wrap{
	-ms-transform: rotate(-45deg);
    -webkit-transform: rotate(-45deg);
    transform: rotate(-45deg) scale(.7);
    overflow: hidden;}
#pm-sectorteam .avia-image-overlay-wrap img{
	-ms-transform: rotate(45deg);
    -webkit-transform: rotate(45deg);
    transform: rotate(45deg) scale(1.4);
    filter: grayscale(1) brightness(1.1);
	transition:all .3s ease-in-out}
#pm-sectorteam .flex_column:hover img{
	filter: grayscale(0) brightness(1);}
#pm-sectorteam h6{
	    font-size: 18px;
	color: #41505D;}
#pm-sectorteam p.pm-jobtitle{
	  text-align: center;
    text-transform: uppercase;
    letter-spacing: .2em;
    font-size: 11px;
    margin: 0;}
#pm-sectorposts .inner_sort_button > span{
	  text-transform: uppercase;
    font-size: 12px;
    letter-spacing: .1em;
    color: white;}
#pm-sectorposts .active_sort .inner_sort_button > span{
	color: #f46B1B}

/* INNER PAGE STYLES */
#top #pm-latestnews .more-link{
		padding: 8px 25px;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: .1em;
    background: white;
    border: 1px solid #f46B1B;
    border-radius: 100px;
		transition:all .3s ease-in-out}
	#top #pm-latestnews .more-link:hover{	
		background: #f46B1B;
    color:white;
		text-decoration:none!important;}
#top #pm-contact input[type="text"],
#top #pm-contact textarea{
	background: rgba(195,216,239,.6);
    border: none;
    color: #41505D;
	letter-spacing: .1em;}
#top #pm-contact input[type="text"]::placeholder,
#pm-contact textarea::placeholder{
	color: rgba(65,80,93,.6);
  text-transform: uppercase;}
#top #pm-contact input[type="submit"]{
	  border-radius: 100px;
    border-width: 1px;
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 0.15em;
		padding:15px 30px}
#top #pm-contact .avia-form-success{
	border: none;
    background: rgba(255,255,255,0.4);
    border-radius: 0;
    box-shadow: 0 0 20px rgba(0,0,0,.4);
    font-family: arial;
    color: #41505D;
    font-weight: normal;
	padding: 50px;}
#pm-contact .avia-icon-list .iconlist_icon{
	    color: #f46b1b;
    font-size: 30px!important;}
#pm-contact .av_iconlist_title{
	margin-top:.85em}
#pm-contact .av_iconlist_title a{
	    font-size: 16px;
    text-decoration: none;}


/* manually copied */
	#pm-home .avia-slide-wrap #pm-doublebutton {
    margin-top: 20px;
}

#pm-home .avia-slideshow-dots {
    position: absolute;
    bottom: -15px;
}

/* DESKTOP STYLES */
@media screen and (min-width:768px){

	#pm-doublebutton > a:nth-child(2){
		opacity: .4;
    font-weight: lighter;
	}
	#pm-home .avia-slide-wrap {
    display: flex;
    flex-direction: row-reverse;
    align-items: center;
}
	#pm-home .avia-slide-wrap .av-slideshow-caption{
    position: relative;
    border-left: 3px solid rgba(255,255,255,.2);
    padding-left: 20px;
    width: 60%;
}

#pm-home .avia-slide-wrap img {
    width: 40%;
}
	#header_main{
		display: flex;
    flex-wrap: wrap;
    flex-direction: row;
	  align-items: center;}
	#header_main .av-logo-container{
		 flex-basis: 25%;
    order: 1;
		margin-right:0}
	#header_main #pm-search{
		flex-basis: 30%;
    order: 2;
    position: relative;}
	#header_main #pm-search form > div{
		max-width:90%;}
	#header_main #pm-search input[type="text"]{
		border-radius:100px;
	padding-left:20px;}
	#header_main #pm-search input[type="submit"]{
		border-top-right-radius:100px;
		border-bottom-right-radius:100px;
	padding-right:5px;}
	#header_main #pm-login{
		flex-basis:20%;
		order:3;
		top: 10px;
    position: relative;}
	#header_main #pm-login #menu-secondary-header-french li{
		display:inline;}
	#header_main #pm-login #menu-secondary-header-french li a{
		text-transform:uppercase;
	letter-spacing:.15em;
		font-weight:100;
	 font-size:11px;
	padding:0 10px;}
	#header_main #pm-login #menu-secondary-header-french{
	display: flex;
		justify-content: flex-end;}
	#header_main #pm-login a{
		font-size: 12px;
    font-weight: bold;}
	#header.av_header_transparency #header_main #pm-login a {
		color: rgba(255,255,255,.6);}
	#header_main #header_main_alternate{
		order:4;
	  width:10%;
	  padding-right:50px;
	  margin:0 auto;
	  margin-left:0}
	#header_main_alternate #menu-item-search,
	#menu-item-searchbox{
		display:none;}
	#header_main_alternate .av-main-nav-wrap{
		background-color:rgba(255,255,255,.1)}
	#header_main .logo{
		margin-top:5px;}
	#header_main #avia-menu{
		 display: flex;
    justify-content: center;}
	#pm-doublebutton > a:nth-child(3){
	opacity: .4;
  font-weight: lighter;}
	#pm-home .av-special-heading-h1{
		margin-left:-15px;}
	/* #pm-home .avia-caption-content{
		border-left: 3px solid rgba(255,255,255,.2);
    padding-left: 20px;} */
	#pm-home .avia-slideshow-inner .av-slideshow-caption{
		width: 60%;
    /* margin-left: 40%; */
		top:0}
	#pm-home .avia-slideshow-inner img{
		width: 40%;
		margin: 0;}
	#pm-homesectors .theta-carousel-inner-container img:nth-child(1){
		left:-450px!important;}
	#pm-homesectors .theta-carousel-inner-container img:nth-child(2){
		left:-300px!important;}
	#pm-homesectors .theta-carousel-inner-container img:nth-child(3){
		left:-150px!important;}
	#pm-homesectors .theta-carousel-inner-container img:nth-child(5){
		left:150px!important;}
	#pm-homesectors .theta-carousel-inner-container img:nth-child(6){
		left:300px!important;}
	#pm-homesectors .theta-carousel-inner-container img:nth-child(7){
		left:450px!important;}
	#pm-homesectors .theta-carousel-outer-container.next-prev-middle #btn-prev {
		left: -25px;}
	#pm-homesectors .theta-carousel-outer-container.next-prev-middle #btn-next {
		right: -25px;}
	#pm-homesectors .av_one_full{
		margin-top:0}
	#pm-homesectors #pm-logos{
		top:-50px;}
	#pm-services .avia-image-container{
	  min-width: 100vw!important;
		margin-top:-50px;
    right: 50px!important;}
	#pm-services .avia-image-container-inner{
		min-width:100vw;}
	#pm-services .avia-image-container-inner img{
		width:100%;}
	#pm-latestnews article.post-entry{
		display:flex;
	  border-bottom: 1px solid #ebebeb;
    padding-bottom: 50px;
    margin-bottom: 50px;}
	#pm-latestnews article.post-entry .blog-meta,
	#pm-latestnews article.post-entry .small-preview{
		width:300px!important;
		height:auto;}
	#top #pm-latestnews article.post-entry .blog-meta{
		overflow: visible;}
	#top #pm-latestnews article.post-entry .small-preview{
		border-radius: 10px;
    box-shadow: 0 0 20px rgba(0,0,0,.25);}
	#top #pm-latestnews .entry-content-wrapper{
		margin-left:30px;}
	#top #pm-latestnews .entry-content-header .entry-title,
	#top #pm-latestnews .entry-content-header .post-meta-infos{
		text-align:left;} 
	#pm-latestnews .comment-container, 
	#pm-latestnews .blog-categories, 
	#pm-latestnews .text-sep-comment,
	#pm-latestnews .text-sep-cat,
	#pm-latestnews .post_delimiter{
		display:none;}
	#top #pm-latestnews .more-link{
    position: absolute;
    bottom: -24px;
		right: 50px;}
	
}

/* LARGE SCREEN STYLES */
@media screen and (min-width:1310px){
	#pm-services .avia-image-container{
	  min-width: 100vw!important;
		margin-top:-50px;
		right: calc((100vw - 1310px) / 2 + 50px)!important;}
	    
}

/* MOBILE STYLES */
@media screen and (max-width:767px){
	#header{
		position:fixed!important;
	    box-shadow: 0 10px 20px -5px rgba(0,0,0,.3);}
	.responsive #top #main{
		padding-top:80px!important}
	#header .av-burger-overlay-scroll{
		overflow:hidden;}
	#header_main #pm-search,
	#header_main #pm-login{
		display:none;}
	#top #header_main .custom-form,
	#top #header_meta,
	#pm-services .avia-image-container,
	#pm-homesectors .tc-button,
	#top #header_main .social_bookmarks{
		display:none!important;}
	#menu-item-searchbox{
		position: absolute;
    top: 85px;
    min-width: 85vw;
    right: 0;}
	#menu-item-searchbox form > div{
		max-width: 100%!important;}
	#header_main #menu-item-searchbox input[type="text"]{
		border-radius:100px;
	padding-left:20px;
	 box-shadow: 0 10px 20px -5px rgba(0,0,0,.3);}
	#header_main #menu-item-searchbox input[type="submit"]{
		border-top-right-radius:100px;
		border-bottom-right-radius:100px;
	padding-right:5px;}
	#top #main .avia-section:first-child{
		padding-top:30px;}
	#top #pm-home .avia-slideshow-arrows > a{
		display:block!important;
		opacity:1!important;}
	#pm-home .avia-slideshow-inner{
		height:auto;}
	#pm-home .avia-slideshow-inner li{
		display: flex;
    flex-wrap: wrap-reverse;}
	#pm-home .avia-slideshow-inner > li .av-slideshow-caption{
		position:relative;}
	#top #pm-home .avia-slideshow-arrows a{
		top:25%;
	  margin:0}
	#pm-home .avia-slideshow-arrows a:before{
		border:none!important;}
	#pm-home .avia-slideshow-dots{
		position:relative;
		margin-top:30px;}
	#top #pm-homesectors .avia-gallery img {
    padding: 0;
    border-radius: 10px;
		border: 3px solid transparent;}
	#pm-services .flex_column_table:nth-child(4){
		    flex-direction: column-reverse;
    display: flex;}
	#top #footer .widget_text{
		margin:0}
	#pm-latestnews article.post-entry{
		padding-bottom:50px;}
	#pm-latestnews article.post-entry .blog-meta,
	#pm-latestnews article.post-entry .small-preview{
		width:300px!important;
		height:150px;}
  #pm-latestnews .comment-container, 
	#pm-latestnews .blog-categories, 
	#pm-latestnews .text-sep-comment,
	#pm-latestnews .text-sep-cat,
	#pm-latestnews .post_delimiter{
		display:none;}
	#top #pm-latestnews .more-link{
	  display: table;
    margin: 0 auto;}
	
	
}

		
		
		</style>
<style>



	</style>

<!-- Scripts/CSS and wp_head hook -->
<?php
/* Always have wp_head() just before the closing </head>
 * tag of your theme, or you will break many plugins, which
 * generally use this hook to add elements to <head> such
 * as styles, scripts, and meta tags.
 */

wp_head();

?>

<script>
$('select').selectpicker();
</script>

</head>




<body id="top" <?php body_class( $custom_body_classes . ' ' . $mfp_alt_text .' ' . $rtl_support . $style . ' ' . $avia_config['font_stack'] . ' ' . $blank . ' ' . $sidebar_styling); avia_markup_helper( array( 'context' => 'body' ) ); ?>>

	<?php 
	
	/**
	 * WP 5.2 add a new function - stay backwards compatible with older WP versions and support plugins that use this hook
	 * https://make.wordpress.org/themes/2019/03/29/addition-of-new-wp_body_open-hook/
	 * 
	 * @since 4.5.6
	 */
	if( function_exists( 'wp_body_open' ) )
	{
		wp_body_open();
	}
	else
	{
		do_action( 'wp_body_open' );
	}
	
	do_action( 'ava_after_body_opening_tag' );
		
	if( 'av-preloader-active av-preloader-enabled' === $preloader )
	{
		echo avia_preload_screen(); 
	}
		
	?>

	<div id='wrap_all'>

	<?php 
	if( ! $blank ) //blank templates dont display header nor footer
	{ 
		//fetch the template file that holds the main menu, located in includes/helper-menu-main.php
		get_template_part( 'includes/helper', 'main-menu' );

	} 
	if(is_page(1471) || is_page(1307) || is_page(1689)):      
        echo '<div id="av_section_1" class="avia-section main_color avia-section-default avia-no-border-styling avia-full-stretch av-parallax-section avia-bg-style-parallax avia-builder-el-0 el_before_av_section avia-builder-el-first container_wrap fullsize" style=" " data-section-bg-repeat="stretch">
            <div class="av-parallax enabled-parallax active-parallax" data-avia-parallax-ratio="0.3" style="top: auto; transform: translate3d(0px, 188px, 0px); height: 631px;">
                <div class="av-parallax-inner main_color avia-full-stretch" style="background-repeat: no-repeat;background-image: url(http://aeon.blvckpixel.com/wp-content/uploads/2021/01/myteknow-bg-flip.jpg);background-attachment: scroll;background-position: center center;"></div>
            </div>
            <div class="container">
			<div class="row">
                <main role="main" itemprop="mainContentOfPage" class="template-page content av-content-full alpha units">
                    <div class="post-entry post-entry-type-page post-entry-605">
                        <div class="entry-content-wrapper clearfix">
                            <div style="height:75px" class="hr hr-invisible avia-builder-el-1 el_before_av_heading avia-builder-el-first "><span class="hr-inner "><span class="hr-inner-style"></span></span>
                            </div>
                            <div style="padding-bottom:10px; color:#ffffff;" class="av-special-heading av-special-heading-h1 custom-color-heading blockquote modern-quote modern-right avia-builder-el-2 el_after_av_hr avia-builder-el-last ">
                                <div class="av-subheading av-subheading_above av_custom_color " style="font-size:15px;">
                                    <p>'. get_field('sub_header').'</p>
                                </div>
                                <h1 class="av-special-heading-tag " itemprop="headline">'.get_field('header').'</h1>
                                <div class="special-heading-border">
                                    <div class="special-heading-inner-border" style="border-color:#ffffff"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
				</div>
                <!-- close content main element -->
            </div>
            <div class="av-extra-border-element border-extra-diagonal diagonal-box-shadow">
                <div class="av-extra-border-outer">
                    <div class="av-extra-border-inner" style="background-color:#ffffff;"></div>
                </div>
            </div>
        </div>';
    else: 
        echo  "<div id='main' class='all_colors' data-scroll-offset='". avia_header_setting( 'header_scroll_offset' ) ."'>";
   
    endif;
    if( isset( $avia_config['temp_logo_container'] ) ) 
    {
        echo $avia_config['temp_logo_container'];
    }
        
    do_action( 'ava_after_main_container' ); 