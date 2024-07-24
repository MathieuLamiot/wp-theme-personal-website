<?php
/**
 * Template Name: Talks Page
 *
 * This template displays a page with Gutenberg blocks followed by a custom query loop for the "talk" post type.
 *
 * @package YourThemeName
 */

get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

        <?php
        // Output the content created with Gutenberg editor
        while ( have_posts() ) : the_post();
            the_content();
        endwhile;
        ?>

        <!-- Custom Content after Gutenberg blocks -->
        <div class="custom-talks-content">
            <?php
            // Custom Query for 'talk' post type
            $args = array(
                'post_type' => 'wpmlt_talk',
                'posts_per_page' => 10000, // Adjust the number of posts per page as needed
            );
            $talk_query = new WP_Query($args);

            if ($talk_query->have_posts()) :

                echo "<div class='business-posts-lists'>";
                while ($talk_query->have_posts()) : $talk_query->the_post();

                    /*
                     * Include the Post-Format-specific template for the content.
                     * If you want to override this in a child theme, then include a file
                     * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                     */
                    get_template_part('template-parts/content', get_post_format());

                endwhile;
                echo "</div>";

                /**
                 * Hook - business_insights_action_posts_navigation.
                 *
                 * @hooked: business_insights_custom_posts_navigation - 10
                 */
                do_action('business_insights_action_posts_navigation');

            else :

                get_template_part('template-parts/content', 'none');

            endif;

            // Restore original Post Data
            wp_reset_postdata();
            ?>
        </div>

    </main><!-- #main -->
</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
?>