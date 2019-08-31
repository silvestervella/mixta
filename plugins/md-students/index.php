<?php
/*
Plugin Name: MixtaDrama Theme - Students profile plugin
Plugin URI: https://mixtadrama.com/
Description: Create profile for every student user
Author: ..
Version: 1.0
*///

add_role(
    'student',
    __( 'Student' ),
    array(
        'read'         => true,  // true allows this capability
        'edit_posts'   => true,
    )
);

function mixtadrama_students() {

    register_post_type( 'achievements',
        array(
        'labels' => array(
            'name' => __( 'Achievements' ),
            'singular_name' => __( 'Achievement' )
        ),
        'public' => false,  // it's not public, it shouldn't have it's own permalink, and so on
        'publicly_queryable' => true,  // you should be able to query it
        'show_ui' => true,  // you should be able to edit it in wp-admin
        'exclude_from_search' => false,  // you should exclude it from search results
        'show_in_nav_products' => false,  // you shouldn't be able to add it to products
        'has_archive' => false,  // it shouldn't have archive page
        'rewrite' => false,  // it shouldn't have rewrite rules
        //'taxonomies'  => array( 'students' ),
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
    register_post_type( 'students',
        array(
        'labels' => array(
            'name' => __( 'Students' ),
            'singular_name' => __( 'Student' )
        ),
        'public' => false,  // it's not public, it shouldn't have it's own permalink, and so on
        'publicly_queryable' => true,  // you should be able to query it
        'show_ui' => true,  // you should be able to edit it in wp-admin
        'exclude_from_search' => false,  // you should exclude it from search results
        'show_in_nav_products' => false,  // you shouldn't be able to add it to products
        'has_archive' => false,  // it shouldn't have archive page
        'rewrite' => false,  // it shouldn't have rewrite rules
        //'taxonomies'  => array( 'students' ),
        'supports' => array( 'title', 'editor', 'thumbnail', 'custom-fields','excerpt' ),
        )
    );


    $taxonomies = array(
        array(
            'slug'         => 'students',
            'single_name'  => 'Student',
            'plural_name'  => 'Students',
            'post_type'    => 'achievements',
            'rewrite'      => array( 'slug' => 'students' ),
            'hierarchical' => true,
        ),
        array(
            'slug'         => 'type',
            'single_name'  => 'Type',
            'plural_name'  => 'Type',
            'post_type'    => 'achievements',
            'rewrite'      => array( 'slug' => 'type' ),
            'hierarchical' => true,
        )
    );
    foreach( $taxonomies as $taxonomy ) {
        $labels = array(
            'name' => $taxonomy['plural_name'],
            'singular_name' => $taxonomy['single_name'],
            'search_items' =>  'Search ' . $taxonomy['plural_name'],
            'all_items' => 'All ' . $taxonomy['plural_name'],
            'parent_item' => 'Parent ' . $taxonomy['single_name'],
            'parent_item_colon' => 'Parent ' . $taxonomy['single_name'] . ':',
            'edit_item' => 'Edit ' . $taxonomy['single_name'],
            'update_item' => 'Update ' . $taxonomy['single_name'],
            'add_new_item' => 'Add New ' . $taxonomy['single_name'],
            'new_item_name' => 'New ' . $taxonomy['single_name'] . ' Name',
            'menu_name' => $taxonomy['plural_name']
        );
        
        $rewrite = isset( $taxonomy['rewrite'] ) ? $taxonomy['rewrite'] : array( 'slug' => $taxonomy['slug'] );
        $hierarchical = isset( $taxonomy['hierarchical'] ) ? $taxonomy['hierarchical'] : true;
    
        register_taxonomy( $taxonomy['slug'], $taxonomy['post_type'], array(
            'hierarchical' => $hierarchical,
            'labels' => $labels,
            'show_ui' => true,
            'query_var' => true,
            'rewrite' => $rewrite,
        ));
    };

}

add_action( 'init', 'mixtadrama_students' );

add_action( 'delete_user', 'mixtadrama_delete_user_term' );

function mixtadrama_delete_user_term( $user_id ) {

    $student = get_userdata( $user_id );
    $term_name = $student->first_name .' '. $student->last_name . ' ('.$student->user_login.')';

    if ($student->roles[0] !== 'student' ) {
        return;
    }

    $term = get_term_by( 'name', $term_name , 'students' );
    $achievments = get_posts(
        array(
        'post_type' => 'achievements',
        'numberposts' => -1,
        'tax_query' => array(
          array(
            'taxonomy' => 'students',
            'field' => 'name',
            'terms' => $term_name , // Where term_id of Term 1 is "1".
            'include_children' => false
          )
        )
        )
          );
    $students = get_posts(
        array(
            'post_type' => 'students',
            'numberposts' => -1
        )
        );

    foreach ( $achievments as $achievment ) :
        wp_trash_post( $achievment->ID);
    endforeach; 
    wp_reset_postdata();
    foreach ( $students as $stu ) :
        wp_trash_post( $stu->ID);
    endforeach; 
    wp_reset_postdata();

    wp_delete_term( $term->term_id,  'students' );
}

add_action( 'profile_update', 'mixtadrama_profile_update', 10, 2 );

function mixtadrama_profile_update($user_id, $old_user_data) {

    $new_data = new WP_User( $user_id  );

    if ($old_user_data->roles == $new_data->roles) {
        return;
    } else if ($new_data->roles[0] == 'student') {
        $student = get_userdata( $user_id );

        $term_name = $student->first_name .' '. $student->last_name . ' ('.$student->user_login.')';

        if ( isset( $user_id  ) ) {
            $achievments_cpt = array(
                'post_title'    => 'Welcome ' . $student->first_name,
                'post_content'  => 'Hi ' .$student->first_name. ' and welcome to your Mixta Drama online profile.',
                'post_status'   => 'publish',
                'post_author'   => 1,
                'post_type'     => 'Achievements'
              );
              $students_cpt = array(
                'post_title'    => $term_name,
                'post_status'   => 'publish',
                'post_author'   => 1,
                'post_type'     => 'Students',
                'post_name'     => $student->user_login
              );
            
            
            $ach_cpt_id = wp_insert_post( $achievments_cpt );
            $stu_cpt_id = wp_insert_post( $students_cpt );
    
            wp_insert_term( $term_name  , 'students' );
    
            wp_set_object_terms($ach_cpt_id, $term_name , 'students');
            //wp_set_object_terms($stu_cpt_id, $term_name , 'students');

        }
    }
}




add_filter( 'manage_students_posts_columns', 'set_custom_edit_students_columns' );
function set_custom_edit_students_columns($columns) {
    unset( $columns['author'] );
    $columns['achievements'] = __( 'Achievements', 'your_text_domain' );
    $columns['level'] = __( 'Level', 'your_text_domain' );

    return $columns;
}

// Add the data to the custom columns for the students post type:
add_action( 'manage_students_posts_custom_column' , 'custom_students_column', 10, 2 );
function custom_students_column( $column, $post_id ) {
    $count = 0;
    $terms;
    $student_post = get_post($post_id);
    $achievments = get_posts(
        array(
        'post_type' => 'achievements',
        'numberposts' => -1,
        'tax_query' => array(
          array(
            'taxonomy' => 'students',
            'field' => 'name',
            'terms' => $student_post->post_title  , 
            'include_children' => false
          )
        )
    )
);
foreach ($achievments as $achievment) {
    $terms = wp_get_post_terms( $achievment->ID , 'type' );
    if ($terms) {
        $count++;
    }
}

$level = floor($count / 5) + 1;


    switch ( $column ) {

        case 'achievements' :
            echo $count;
            break;

        case 'level' :
            echo $level; 
            break;

    }
}



function mixtadrama_default_comments_on( $data ) {
    if( $data['post_type'] == 'students' ) {
        $data['comment_status'] = 1;
    }

    return $data;
}
add_filter( 'wp_insert_post_data', 'mixtadrama_default_comments_on' );

?>