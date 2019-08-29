<?php

/**
 * 1. Register and enqueue script and styles
 */
    // De-register HTML5 Blank styles
    function mixtadrama_styles_make_child_active()
    {
    wp_deregister_style('html5blank'); // Enqueue it!
    }
    add_action('wp_enqueue_scripts', 'mixtadrama_styles_make_child_active', 100); // Add Theme Child Stylesheet

    // Load HTML5 Blank Child styles
    function mixtadrama_styles_child()
    {
    // Register Child Styles
    wp_register_style('mixtadrama-child', get_stylesheet_directory_uri() . '/style.css', array(), '1.0', 'all');
    //wp_register_style('child-bootstrap', get_stylesheet_directory_uri() . '/css/bootstrap.min.css', array(), '1.0', 'all');
    // wp_register_style('owlcarousel-style', get_stylesheet_directory_uri() . '/css/owl.carousel.min.css', array(), '1.0', 'all');
    // wp_register_style('owlcarousel-animate', get_stylesheet_directory_uri() . '/css/animate.css', array(), '1.0', 'all');
    wp_register_style('child-all', get_stylesheet_directory_uri() . '/css/styles.css', array(), '1.0', 'all');

    // Enqueue Child Styles
    //wp_enqueue_style('child-bootstrap'); 
    wp_enqueue_style('child-fontawesome'); 
    // wp_enqueue_style('owlcarousel-style'); 
    // wp_enqueue_style('owlcarousel-animate'); 
    wp_enqueue_style('mixtadrama-child'); 
    wp_enqueue_style('child-all');

    //Register Child Scripts
    //wp_register_script( 'bootstrap', get_stylesheet_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ) );
    wp_register_script( 'theme-script', get_stylesheet_directory_uri() . '/js/script.js', array( 'jquery' ) );
    // wp_register_script( 'owlcarousel', get_stylesheet_directory_uri() . '/js/owl.carousel.min.js', array( 'jquery' ) );
    
    // Enqueue Child Scripts
    //wp_enqueue_script( 'bootstrap' ); 
    wp_enqueue_script( 'theme-script' );   
    // wp_enqueue_script( 'owlcarousel' );   

}
add_action('wp_enqueue_scripts', 'mixtadrama_styles_child', 20); // Add Theme Child Stylesheet


/* logo */

function mixtadrama_custom_logo_setup() {
    $defaults = array(
    'height'      => 100,
    'width'       => 400,
    'flex-height' => true,
    'flex-width'  => true,
    'header-text' => array( 'site-title', 'site-description' ),
    );
    add_theme_support( 'custom-logo', $defaults );
   }
   add_action( 'after_setup_theme', 'mixtadrama_custom_logo_setup' );

   /* Register News post type */

   register_post_type( 'news',
   array(
     'labels' => array(
       'name' => __( 'News' ),
       'singular_name' => __( 'News' )
     ),
     'public' => true,  // it's not public, it shouldn't have it's own permalink, and so on
     'publicly_queryable' => true,  // you should be able to query it
     'show_ui' => true,  // you should be able to edit it in wp-admin
     'exclude_from_search' => false,  // you should exclude it from search results
     'show_in_nav_products' => false,  // you shouldn't be able to add it to products
     'has_archive' => false,  // it shouldn't have archive page
     'rewrite' => false,  // it shouldn't have rewrite rules
     'taxonomies'          => array( 'category' ),
     'supports' => array(
         'title',
         'editor',
         'excerpt',
         'trackbacks',
         'custom-fields',
         'comments',
         'revisions',
         'thumbnail',
         'author',
         'page-attributes',),
   )
   );

   
   /* Register category for news cpt */
   function mixtadrama_reg_cat() {
    register_taxonomy_for_object_type('category','news');
}
add_action('init', 'mixtadrama_reg_cat');



// Restrict username registration to alphanumerics
add_filter('registration_errors', 'mixtadrama_limit_username_alphanumerics', 10, 3);
function mixtadrama_limit_username_alphanumerics ($errors, $name) {
  if ( ! preg_match('/^[A-Za-z0-9]{3,16}$/', $name) ){
    $errors->add( 'user_name', __('<strong>ERROR</strong>: Username can only contain alphanumerics (A-Z 0-9)','CCooper') );
  }
  return $errors;
}