<?php
add_shortcode('theta-carousel', 'theta_carousel_shortcode');

function theta_carousel_shortcode($atts) {


    wp_enqueue_script("jquery");
    wp_register_script('theta-carousel-client-script', THETA_CAROUSEL_PLUGIN_PATH.'js/client.js', array( 'jquery' ));
    wp_enqueue_script('theta-carousel-client-script');

    wp_register_style('theta-carousel-common-css', THETA_CAROUSEL_PLUGIN_PATH.'css/theta-carousel-common.css');
    wp_enqueue_style('theta-carousel-common-css');
    wp_enqueue_style( 'dashicons' );
    extract(shortcode_atts(array(
		'id' => 0,
    ), $atts));
    
 
    if ($id == 0) {
        return "<div id='theta-crousel-invalid-postid'>".esc_html__("Theta crousel - Valid ID has not been provided in the shortcode", "theta_carousel" )."</div>\n";
    }

    $metadata = get_metadata('post', $id);
    $slides = $metadata['theta_carousel_slides'][0];
    $config = $metadata['theta_carousel_config'][0];

    $output = "";
    
    $output.="<div class='theta-carousel-outer-container'>";
    $output.="  <div class='theta-carousel-container'>";
    $output.="      <input type='hidden' id='theta_carousel_slides' disabled value='".esc_attr($slides)."'>";
    $output.="      <input type='hidden' id='theta_carousel_config' disabled value='".esc_attr($config)."'>";
    $output.="  </div>";
    $output.="</div>";

    return $output;
}

?>
