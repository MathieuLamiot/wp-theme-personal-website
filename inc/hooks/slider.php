<?php
if (!function_exists('business_insights_banner_slider_args')) :
    /**
     * Banner Slider Details
     *
     * @since Business Insights 1.0.0
     *
     * @return array $qargs Slider details.
     */
    function business_insights_banner_slider_args()
    {
        $business_insights_banner_slider_number = absint(business_insights_get_option('number_of_home_slider'));
        $business_insights_banner_slider_from = esc_attr(business_insights_get_option('select_slider_from'));
        switch ($business_insights_banner_slider_from) {
            case 'from-page':
                $business_insights_banner_slider_page_list_array = array();
                for ($i = 1; $i <= $business_insights_banner_slider_number; $i++) {
                    $business_insights_banner_slider_page_list = business_insights_get_option('select_page_for_slider_' . $i);
                    if (!empty($business_insights_banner_slider_page_list)) {
                        $business_insights_banner_slider_page_list_array[] = absint($business_insights_banner_slider_page_list);
                    }
                }
                // Bail if no valid pages are selected.
                if (empty($business_insights_banner_slider_page_list_array)) {
                    return;
                }
                /*page query*/
                $qargs = array(
                    'fields' => 'ids',
                    'posts_per_page' => absint($business_insights_banner_slider_number),
                    'post_type' => 'page',
                    'post__in' => $business_insights_banner_slider_page_list_array,
                );
                return $qargs;
                break;

            case 'from-category':
                $business_insights_banner_slider_category = absint(business_insights_get_option('select_category_for_slider'));
                $qargs = array(
                    'fields' => 'ids',
                    'posts_per_page' => absint($business_insights_banner_slider_number),
                    'post_type' => 'post',
                    'cat' => absint($business_insights_banner_slider_category),
                );
                return $qargs;
                break;

            default:
                break;
        }
?>
    <?php
    }
endif;

if (!function_exists('mlt_add_permanent_slider_content')) :
    /**
     * Add permanent custom content to the already computed slider WP Query
     *
     * @param WP_Query $variable_slider_content_query List of posts to be added to the slider, along with the permanent content
     * 
     * @return WP_Query $merged_query Posts to be added to the slider.
     */
    function mlt_add_permanent_slider_content($variable_slider_content_query)
    {

        if (is_front_page()) {
            $permanent_slider_content_args = array(
                'fields' => 'ids',
                'post_type' => 'page',
                'title' => 'About me',
            );
            $permanent_slider_content_query = new WP_Query($permanent_slider_content_args);

            //now you got post IDs in $query->posts
            $allTheIDs = array_merge($permanent_slider_content_query->posts, $variable_slider_content_query->posts,);
        } else {
            $allTheIDs = $variable_slider_content_query->posts;
        }
        //new query, using post__in parameter
        $merged_query = new WP_Query(array(
            'post__in' => $allTheIDs,
            'post_type' => 'any',
        ));
        return $merged_query;
    ?>
    <?php
    }
endif;


if (!function_exists('business_insights_banner_slider')) :
    /**
     * Banner Slider
     *
     * @since Business Insights 1.0.0
     *
     */
    function business_insights_banner_slider()
    {
        $business_insights_slider_button_text = esc_html(business_insights_get_option('button_text_on_slider'));
        $business_insights_slider_excerpt_number = absint(business_insights_get_option('number_of_content_home_slider'));
        if (1 != business_insights_get_option('show_slider_section')) {
            return null;
        }
        $business_insights_banner_slider_args = business_insights_banner_slider_args();
        $business_insights_banner_slider_query = new WP_Query($business_insights_banner_slider_args);
        $mlt_banner_slider_query = mlt_add_permanent_slider_content($business_insights_banner_slider_query) ?>
        <section class="twp-slider-wrapper">
            <div class="twp-slider">
                <?php
                if ($mlt_banner_slider_query->have_posts()) :
                    while ($mlt_banner_slider_query->have_posts()) : $mlt_banner_slider_query->the_post();
                        if (has_excerpt()) {
                            $business_insights_slider_content = get_the_excerpt();
                        } else {
                            $business_insights_slider_content = business_insights_words_count($business_insights_slider_excerpt_number, get_the_content());
                        }
                ?>
                        <div class="single-slide">
                            <?php if (has_post_thumbnail()) {
                                $thumb_size = 'full';
                                if ( wp_is_mobile() ) {
                                    $thumb_size = 'medium_large';
                                }
                                $thumb_id = get_post_thumbnail_id(get_the_ID());
                                $thumb = wp_get_attachment_image_src($thumb_id, $thumb_size);
                                $url = $thumb['0'];  
                                // Get the attachment description and use it as the alt attribute
                                $alt_text = get_post_meta($thumb_id, '_wp_attachment_image_alt', true);
                                if (empty($alt_text)) {
                                    // If no alt text is set, use the attachment description
                                    $attachment = get_post($thumb_id);
                                    $alt_text = $attachment->post_content; // This is the description field
                                }
                                // Fallback if description is empty
                                if (empty($alt_text)) {
                                    $alt_text = get_the_title($thumb_id); // Fallback to image title if description is not available
                                }
                                ?>
                                <div class="slide-bg bg-image-slider animated">
                                    <img src="<?php echo esc_url($url); ?>" alt="<?php echo esc_attr($alt_text); ?>" class="slider-image">
                                </div>
                            <?php } ?>
                            <div class="container">
                                <div class="slide-text animated secondary-textcolor">
                                    <div class="table-align">
                                        <div class="table-align-cell v-align-bottom">
                                            <div class="row">
                                                <div class="col-md-10 col-sm-12">
                                                    <div class="layer layer-fadeInLeft">
                                                        <h2 class="slide-title"><?php the_title(); ?></h2>
                                                    </div>
                                                    <div class="layer layer-fadeInRight visible hidden-xs">
                                                    </div>
                                                    <div class="layer layer-fadeInUp">
                                                        <div class="slider-button">
                                                            <a href="<?php the_permalink(); ?>" class="btn-link btn-link-primary">
                                                                <?php echo esc_html($business_insights_slider_button_text); ?>
                                                                <i class="ion-ios-arrow-right"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php
                    endwhile;
                    wp_reset_postdata();
                endif; ?>
            </div>
        </section>
        <!-- end slider-section -->
<?php
    }
endif;
add_action('business_insights_action_slider_post', 'business_insights_banner_slider', 10);
