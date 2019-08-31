<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */
 
get_header(); ?>
 
    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
 
        <?php
        // Start the loop.
        while ( have_posts() ) : the_post();

        $terms = wp_get_post_terms( get_the_ID() , 'type' );

            foreach ($terms as $term) {

                echo '<div class="achiev-type">Achievement: ';

                switch ($term->name) {
                    case 'Completed Workshop':
                    echo 'ill haqalla workshop mannnn';
                    break;
                    case 'iehor':
                    echo 'ill haqalla iehor mannnn';
                    break;
                }
                echo '</div>';
                echo '<div class"achiev-desc">' . the_content() . '</div>';
            }

            // If comments are open or we have at least one comment, load up the comment template.
            if ( comments_open() || get_comments_number() ) :
                comments_template();
            endif;
 
        // End the loop.
        endwhile;
        ?>
 
        </main><!-- .site-main -->
    </div><!-- .content-area -->
 
<?php get_footer(); ?>