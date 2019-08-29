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