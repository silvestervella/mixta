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

?>

<main role="main">
    <section class="student-info">
        <div class="author-img">
            <?php echo get_avatar($user->ID , 65) ?>
        </div>
        <h2><?php echo $user->first_name . ' ' . $user->last_name?>: 
        <?php 
            echo '<div class="achiev-count">Achievements: ';
            foreach ($achievments as $achievment) {
                $terms = wp_get_post_terms( $achievment->ID , 'type' );
                if ($terms) {
                    $achiev_count++;
                }
            }
            echo '<span>'.$achiev_count.'</span>';
            echo '</div>'; // .achiev-count
            $level = floor($achiev_count / 5) + 1;
            echo '<div class="level">Level: <span>'.$level.'</span></div>';
        echo $stars ?></h2>
    </section>
    <div class="posts-sec-outer">
        <div class="container">
        <?php 
            foreach ($achievments as $achievment) {
                $types = wp_get_post_terms( $achievment->ID , 'type' );
                $gravatar = get_avatar($achievment->post_author , 45);
                $achievment_post .= '<div class="post-wrap">';
                $achievment_post .= '<div class="author-img">'.$gravatar.'</div>';
                if ($types) {
                    foreach ($types as $type_name) {
                        $achievment_type .= $type_name->name . ' ';
                    }
                    $achievment_post .=  '<h3 class="achiev-type">Achievement: '.$achievment_type. '</h3>';
                    $achievment_type = '';
                } else  {
                    $achievment_post .= '<h3>'.$achievment->post_title.'</h3>';
                }
                $achievment_post .=  '<div class"achiev-desc">' . $achievment->post_content . '</div>';
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
