<?php
/*
 * Template Name: Students Template
 */

 ?>
 <?php get_header(); 
 $post = get_post();
 $user = get_user_by('login' , $post->post_name);

$achievments = get_posts(
        array(
        'post_type' => 'achievements',
        'numberposts' => -1,
        'tax_query' => array(
          array(
            'taxonomy' => 'students',
            'field' => 'name',
            'terms' => $post->post_title , 
            'include_children' => false
          )
        )
    )
);

$achievment_post;
$achiev_count = 0;
$achievment_type;

if( wp_get_referer() ) {
    echo '<a id="back-arrow" href="' . wp_get_referer() . '" ><i class="fas fa-arrow-left"></i></a>';
}

?>

<main role="main">
    <section class="student-info">
        <div class="author-cover-photo">
            <?php echo get_avatar($user->ID , 90) ?>
        </div>
        <div class="author-details">
        <h2><?php echo '<div class="name">' . $user->first_name . ' ' . $user->last_name . '</div>'?> 
        <?php 
                    foreach ($achievments as $achievment) {
                        $terms = wp_get_post_terms( $achievment->ID , 'type' );
                        if ($terms) {
                            $achiev_count++;
                        }
                    }
            $level = floor($achiev_count / 5) + 1;
            echo '<div class="level">Level: <span>'.$level.'</span></div>';
            echo '<div class="achiev-count">Achievements: ';

            echo '<span>'.$achiev_count.'</span>';
            echo '</div>'; // .achiev-count

        echo $stars ?></h2>
            <?php echo get_avatar($user->ID , 130) ?>
        </div>
    </section>
    <div class="posts-sec-outer">
        <div class="container">
        <?php 
            foreach ($achievments as $achievment) {
                $types = wp_get_post_terms( $achievment->ID , 'type' );
                $gravatar = get_avatar($achievment->post_author , 45);
                $achievment_post .= '<div class="post-wrap">';

                // $achievment_post .= '<div class="author-img">'.$gravatar.'</div>';   avatar for post author not student
                if ($types) {
                    foreach ($types as $type_name) {
                        $achievment_type .= $type_name->name . ' ';
                    }
                    $achievment_post .=  '<h3 class="achiev-type">Achievement: '.$achievment_type. '<span>'. $achievment->post_date.'</span></h3>';
                    $achievment_type = '';
                } else  {
                    $achievment_post .= '<h3>'.$achievment->post_title. '<span>'. $achievment->post_date.'</span></h3>';
                }
                $achievment_post .=  '<div class"achiev-desc">' . $achievment->post_content .'</div>';
                /*
                $achievment_post .= '<div class="share"><a href="http://www.facebook.com/dialog/feed?  
                app_id=2386929224877466&  
                link=http://developers.facebook.com/docs/reference/dialogs/&
                picture=http://fbrell.com/f8.jpg&  
                name=Facebook%20Dialogs&  
                caption=Reference%20Documentation& 
                description=Dialogs%20provide%20a%20simple,%20consistent%20interface%20for%20applications%20to%20interact%20with%20users.&
                quote=Facebook%20Dialogs%20are%20so%20easy!&
                redirect_uri=http://www.mixtadrama.com"
                target="_blank" >Share <i class="fa fa-facebook-f"></i></a></div>';
                */
                $achievment_post .= '</div>'; //.post-wrap
            }
            echo $achievment_post;
        ?>
        </div>
        <!-- /container -->
    </div>
    <!-- /posts-sec-outer -->
</main>

<?php // get_sidebar(); ?>

<?php get_footer();?>
