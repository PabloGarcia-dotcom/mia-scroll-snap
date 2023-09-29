<?php
get_header();
?>

<main id="primary" class="site-main">

    <?php
    // Custom Query for Posts
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $args  = array(
        'post_type'      => 'post', // Adjust the post type if needed
        'posts_per_page' => 2, // Number of posts per page
        'paged'          => $paged,
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) :

        if (is_home() && !is_front_page()) :
            ?>
            <header>
                <h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
            </header>
            <?php
        endif;

        /* Start the Loop */
        while ($query->have_posts()) :
            $query->the_post();
            ?>
            <!-- Start of the Loop content -->
            <div class="snap-container">


                <article class="article-container">

                    <div class="background-image"
                         style="background-image: url('<?php echo esc_url(get_the_post_thumbnail_url()); ?>'); background-size: cover; background-position: center; width: 100%; height: 50vh;">

                        <?php
                        $categories = get_the_category(); // Get the post's categories
                        if ($categories) {
                            echo '<div class="post-categories">';
                            $category_links = array(); // Create an array to store category links
                            foreach ($categories as $category) {
                                $category_links[] = '<a href="' . esc_url(get_category_link($category->term_id)) . '">' . esc_html($category->name) . '</a>';
                            }
                            // Join the category links with spaces or any separator you prefer
                            echo implode(' ', $category_links);
                            echo '</div>';
                        }
                        ?>
                    </div>

                    <div class="text-container">
                        <h1><a style="text-decoration: none;" href="<?php the_permalink(); ?>">
                                <?php
                                $title       = get_the_title(); // Get the post title
                                $title_words = explode(' ', $title); // Split the title into words

                                // Check if the title has more than 13 words
                                if (count($title_words) > 13) {
                                    // Truncate the title to 13 words and add an ellipsis
                                    echo implode(' ', array_slice($title_words, 0, 13)) . '...';
                                } else {
                                    // Display the full title
                                    echo $title;
                                }
                                ?>
                            </a></h1>

                        <p class="p">
                            <?php
                            $full_content = get_the_content();
                            custom_truncated_content($full_content, 20);
                            ?>
                        </p>

                        <a class="herz-button" href="<?php the_permalink(); ?>">Pročitaj više</a>

                    </div>

                </article>

            </div> <!-- Close the "snap-container" div -->
            <?php
        endwhile;

        // Display pagination links in a separate snap container at the end
        if (paginate_links(array('total' => $query->max_num_pages))) {
            echo '<div class="snap-container">';
            echo '<article>';
            echo '<div class="pagination-container">'; // Wrap the pagination links in a container
            echo paginate_links(array(
                'total'    => $query->max_num_pages,
                'prev_text' => __('&laquo; Prethodno'),
                'next_text' => __('Slijedeće &raquo;'),
            ));

            echo '</div>'; // Close the pagination container
            echo '</article>';
            echo '</div>';
        }

        wp_reset_postdata(); // Restore original post data

    else :

        // No posts found
        get_template_part('template-parts/content', 'none');

    endif;
    ?>

</main><!-- #main -->

<?php
get_sidebar();
get_footer();
?>
