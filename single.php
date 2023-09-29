<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package mia-scroll-snap
 */

get_header();
?>

<style>
    /* Add custom styles */
    .custom-container {
        padding-top: 100px;
        text-align: center;
		margin-left: 20px;
		margin-right:20px;
    }
</style>

<main id="primary" class="site-main">

    <?php
    while ( have_posts() ) :
        the_post();

        // Add the custom container class to the entry-content div
        echo '<div class="custom-container">';
        get_template_part( 'template-parts/content', get_post_type() );
        echo '</div>';




        // If comments are open or we have at least one comment, wrap the comments in a custom container
        if ( comments_open() || get_comments_number() ) :
            echo '<div class="custom-container">';
            comments_template();
            echo '</div>';
        endif;

    endwhile; // End of the loop.
    ?>

</main><!-- #main -->
<div class="custom-container">
    <?php
    get_sidebar();
    ?>
</div>

<div class="custom-container">
    <?php
    get_footer();
    ?>
</div>