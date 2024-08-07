<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Business Insights
 */

if (!function_exists('business_insights_posted_details')) :
    /**
     * Prints HTML with meta information for the current post-date/time and author.
     */
    function business_insights_posted_details()
    {
        global $post;
        $author_id = $post->post_author;
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
        if (get_the_time('U') !== get_the_modified_time('U')) {
            $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
        }

        $time_string = sprintf($time_string,
            esc_attr(get_the_date('c')),
            esc_html(get_the_date()),
            esc_attr(get_the_modified_date('c')),
            esc_html(get_the_modified_date())
        );

        $year = get_the_date('Y');
        $month = get_the_date('m');
        $day = get_the_date('d');
        $link = get_day_link($year, $month, $day);

        $posted_on = sprintf(
            esc_html__( 'Posted On %s', 'business-insights' ),
            '<a href="' . esc_url( $link ) . '" rel="bookmark">' . $time_string . '</a>'
        );

        $byline = sprintf(
            esc_html__( 'by %s', 'business-insights' ),
            '<a class="url" href="' . esc_url(get_author_posts_url($author_id)) . '">' . esc_html(get_the_author_meta('display_name', $author_id)) . '</a>'
        );

        echo '<span class="posted-on secondary-font">' . $posted_on . '</span><span class="author secondary-font"> ' . $byline . '</span>'; // WPCS: XSS OK.


        if (!is_single() && !post_password_required() && (comments_open() || get_comments_number())) {
            echo '<span class="comments-link secondary-font">';
            comments_popup_link(esc_html__('- 0 comments', 'business-insights'), esc_html__('- 1 Comment', 'business-insights'), esc_html__('- % Comments', 'business-insights'));
            echo '</span>';
        }

        edit_post_link(
            sprintf(
            /* translators: %s: Name of current post */
                the_title('<span class="screen-reader-text">"', '"</span>', false)
            ),
            '<span class="edit-link secondary-font">',
            '</span>'
        );
    }
endif;

if (!function_exists('business_insights_entry_category')) :
    /**
     * Prints HTML with meta information for the categories, tags and comments.
     */
    function business_insights_entry_category()
    {
        /* translators: used between list items, there is a space after the comma */
        $categories_list = get_the_category_list(esc_html__('/', 'business-insights'));
        if ($categories_list) {
            printf(esc_html__('%1$s', 'business-insights'), $categories_list);
        }
    }
endif;

if (!function_exists('business_insights_entry_tags')) :
    /**
     * Prints HTML with meta information for the categories, tags and comments.
     */
    function business_insights_entry_tags()
    {
        // Hide category and tag text for pages.
        if ('post' === get_post_type()) {

            /* translators: used between list items, there is a space after the comma */
            $tags_list = get_the_tag_list('', esc_html__('/', 'business-insights'));
            if ($tags_list) {
                printf('<span class="tags-links"> ' . esc_html__('Tagged: %1$s', 'business-insights') . '</span>', $tags_list); // WPCS: XSS OK.
            }
        }
    }
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function business_insights_categorized_blog()
{
    if (false === ($all_the_cool_cats = get_transient('business_insights_categories'))) {
        // Create an array of all the categories that are attached to posts.
        $all_the_cool_cats = get_categories(array(
            'fields' => 'ids',
            'hide_empty' => 1,
            // We only need to know if there is more than one category.
            'number' => 2,
        ));

        // Count the number of categories that are attached to the posts.
        $all_the_cool_cats = count($all_the_cool_cats);

        set_transient('business_insights_categories', $all_the_cool_cats);
    }

    if ($all_the_cool_cats > 1) {
        // This blog has more than 1 category so business_insights_categorized_blog should return true.
        return true;
    } else {
        // This blog has only 1 category so business_insights_categorized_blog should return false.
        return false;
    }
}

/**
 * Flush out the transients used in business_insights_categorized_blog.
 */
function business_insights_category_transient_flusher()
{
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    // Like, beat it. Dig?
    delete_transient('business_insights_categories');
}

add_action('edit_category', 'business_insights_category_transient_flusher');
add_action('save_post', 'business_insights_category_transient_flusher');
