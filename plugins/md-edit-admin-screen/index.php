<?php
/*
Plugin Name: MixtaDrama Theme - Edit Admin Screen
Plugin URI: https://mixtadrama.com/
Description: Remove menu items from dashboard and some styling
Author: ..
Version: 1.0
*///

add_action( 'admin_menu', 'mixtadrama_my_remove_menus', 999 );

function mixtadrama_my_remove_menus() {
    
    $user = wp_get_current_user();

    if(!current_user_can( 'manage_options' ) || $user && isset($user->user_login) && 'claytonpace' == $user->user_login) {
     
        remove_menu_page( 'tools.php' );  
        remove_menu_page( 'jetpack' );  
        remove_menu_page( 'edit.php' );
        remove_menu_page( 'edit.php' );
        remove_menu_page( 'edit.php?post_type=elementor_library' );
        remove_menu_page( 'edit.php?post_type=achievements' );
        remove_menu_page( 'edit.php?post_type=students' );
        remove_menu_page( 'edit.php?post_type=html5-blank' );
        remove_menu_page( 'wpcf7' );
        remove_menu_page( 'envato-elements' );
        
    }
}

function mixtadrama_remove_from_admin_bar($wp_admin_bar) {
    
    $user = wp_get_current_user();

    if(!current_user_can( 'manage_options' ) || $user && isset($user->user_login) && 'claytonpace' == $user->user_login) {
        $wp_admin_bar->remove_node('si_menu');
        // WordPress Core Items (uncomment to remove)
        $wp_admin_bar->remove_node('updates');
        $wp_admin_bar->remove_node('comments');
        $wp_admin_bar->remove_node('new-content');
        $wp_admin_bar->remove_node('wp-logo');
        //$wp_admin_bar->remove_node('site-name');
        $wp_admin_bar->remove_node('my-account');
        $wp_admin_bar->remove_node('search');
        $wp_admin_bar->remove_node('customize');
    }
}
add_action('admin_bar_menu', 'mixtadrama_remove_from_admin_bar', 999);



// Remove dash widgets
add_action('wp_dashboard_setup', 'mixtadrama_remove_all_dashboard_meta_boxes', 9999 );

function mixtadrama_remove_all_dashboard_meta_boxes()
{
    $user = wp_get_current_user();

    if(!current_user_can( 'manage_options' ) || $user && isset($user->user_login) && 'claytonpace' == $user->user_login) {
        global $wp_meta_boxes;
        $wp_meta_boxes['dashboard']['normal']['core'] = array();
        $wp_meta_boxes['dashboard']['side']['core'] = array();
    }
}




// Admin footer modification
  
function mixtadrama_remove_footer_admin () 
{
    echo '<span id="footer-thankyou">&copy;MixtaDrama - '.date("Y").'</span>';
}
 
add_filter('admin_footer_text', 'mixtadrama_remove_footer_admin');




// Add custom css to admin area

add_action( 'admin_enqueue_scripts', 'mixtadrama_custom_admin_css' );
function mixtadrama_custom_admin_css() {
    
    $user = wp_get_current_user();

    if(!current_user_can( 'manage_options' ) || $user && isset($user->user_login) && 'claytonpace' == $user->user_login) {
        wp_enqueue_style( 'admin_css', get_template_directory_uri() . '/css/admin-style-non-admin.css', false, '1.0.0' );
    }
return;
}

?>