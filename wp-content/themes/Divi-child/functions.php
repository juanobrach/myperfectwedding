<?php

show_admin_bar( false );

include dirname(__FILE__) . '/helpers.php';
include dirname(__FILE__) . '/shortcodes.php';
include dirname(__FILE__) . '/hooks/add-slug-body_class.php';
include dirname(__FILE__) . '/widgets/featured_posts_widget.php';
include dirname(__FILE__) . '/widgets/recent_posts_widget.php';

function theme_styles(){
  wp_enqueue_style('styles', get_template_directory_uri() . '/style.css');
  wp_enqueue_style('custom_style', get_bloginfo( 'stylesheet_directory' ) . '/app/build/css/main.css');
  // Include Handlee Fonts
  wp_enqueue_style('Handlee-font','https://fonts.googleapis.com/css?family=Handlee'
);
  wp_enqueue_style('fancybox','https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css');
  wp_enqueue_style('fancybox-btns','https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/helpers/jquery.fancybox-buttons.css');

  wp_enqueue_style('flexslider', 'https://cdnjs.cloudflare.com/ajax/libs/flexslider/2.6.1/flexslider.min.css');
  wp_enqueue_style('foundicons', 'https://cdnjs.cloudflare.com/ajax/libs/foundicons/3.0.0/foundation-icons.min.css');
}
add_action( 'wp_enqueue_scripts', 'theme_styles' );

function theme_js(){

  // Load libraries
  wp_enqueue_script('masonry_library', get_bloginfo( 'stylesheet_directory' ) . '/app/vendor/masonry.min.js', array('jquery'));
  wp_enqueue_script('images_loaded', get_bloginfo( 'stylesheet_directory' ). '/app/vendor/imagesloaded.pkgd.min.js', array('jquery'));
  wp_enqueue_script('nested_js', get_bloginfo( 'stylesheet_directory' ). '/app/vendor/jquery.nested.js', array('jquery'));
  wp_enqueue_script('grid_boxes_animations', get_bloginfo( 'stylesheet_directory' ). '/app/js/get_grid_boxes_reviews_Animations.js', array('jquery'));
  wp_enqueue_script('jquery_flexslider', 'https://cdnjs.cloudflare.com/ajax/libs/flexslider/2.6.1/jquery.flexslider-min.js', array('jquery'));
   wp_enqueue_script('mason',  get_bloginfo( 'stylesheet_directory' ) . '/app/vendor/mason.js', array('jquery'));



  // Load custom scripts
  wp_enqueue_script('masonry_config',get_bloginfo( 'stylesheet_directory' ) . '/app/js/masonry_config.js', array('jquery'));
  wp_enqueue_script('services_grid', get_bloginfo( 'stylesheet_directory' ). '/app/js/servicesGrid.js', array('jquery'));
  
  // Widget scripts
  wp_enqueue_script('featured_posts_widget', get_bloginfo('stylesheet_directory'). '/app/js/featured_posts_widget.js', array('jquery'));

  // Home sections transitions
  wp_enqueue_script('sections_transitions', get_bloginfo('stylesheet_directory'). '/app/js/sections_transitions.js', array('jquery'));

  wp_enqueue_script('fancybox ','http://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js', array('jquery'));
}
add_action( 'wp_enqueue_scripts', 'theme_js' );
/*
update_option('siteurl','http://www.myperfectweddingmexico.com/');
update_option('home','http://www.myperfectweddingmexico.com/');


*/