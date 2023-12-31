<?php
/**
 * Theme widgets.
 *
 * @package Business Insights
 */

// Load widget base.
require_once get_template_directory() . '/inc/widgets/widget-base-class.php';

if (!function_exists('business_insights_load_widgets')) :
    /**
     * Load widgets.
     *
     * @since 1.0.0
     */
    function business_insights_load_widgets()
    {
        // Recent Post widget.
        register_widget('TWP_sidebar_widget');

        // Auther widget.
        register_widget('TWP_Author_Post_widget');

        // Social widget.
        register_widget('TWP_Social_widget');
    }
endif;
add_action('widgets_init', 'business_insights_load_widgets');

/*Grid Panel widget*/
if (!class_exists('TWP_sidebar_widget')) :

    /**
     * Popular widget Class.
     *
     * @since 1.0.0
     */
    class TWP_sidebar_widget extends Business_Insights_Widget_Base
    {

        /**
         * Sets up a new widget instance.
         *
         * @since 1.0.0
         */
        function __construct()
        {
            $opts = array(
                'classname' => 'business_insights_popular_post_widget',
                'description' => esc_html__('Displays post form selected category specific for popular post in sidebars.', 'business-insights'),
                'customize_selective_refresh' => true,
            );
            $fields = array(
                'title' => array(
                    'label' => esc_html__('Title:', 'business-insights'),
                    'type' => 'text',
                    'class' => 'widefat',
                ),
                'post_category' => array(
                    'label' => esc_html__('Select Category:', 'business-insights'),
                    'type' => 'dropdown-taxonomies',
                    'show_option_all' => esc_html__('All Categories', 'business-insights'),
                ),
                'post_number' => array(
                    'label' => esc_html__('Number of Posts:', 'business-insights'),
                    'type' => 'number',
                    'default' => 4,
                    'css' => 'max-width:60px;',
                    'min' => 1,
                    'max' => 10,
                ),
            );

            parent::__construct('business-insights-popular-sidebar-layout', esc_html__('GW: Recent Post', 'business-insights'), $opts, array(), $fields);
        }

        /**
         * Outputs the content for the current widget instance.
         *
         * @since 1.0.0
         *
         * @param array $args Display arguments.
         * @param array $instance Settings for the current widget instance.
         */
        function widget($args, $instance)
        {

            $params = $this->get_params($instance);

            echo $args['before_widget'];

            if (!empty($params['title'])) {
                echo $args['before_title'] . esc_html( $params['title'] ) . $args['after_title'];
            }

            $qargs = array(
                'posts_per_page' => esc_attr($params['post_number']),
                'no_found_rows' => true,
            );
            if (absint($params['post_category']) > 0) {
                $qargs['cat'] = absint($params['post_category']);
            }
            
            $recent_posts_query = new WP_Query($qargs);
            
            $count = 1;
            if ($recent_posts_query->have_posts()) :  ?>
            <div class="twp-recent-widget">
                <ul class="recent-widget-list">
                    <?php while ($recent_posts_query->have_posts()) :
                        $recent_posts_query->the_post(); ?>
                        <li>
                            <article class="article-list">
                                <div class="article-image">
                                    <?php if (has_post_thumbnail()) {
                                        $thumb = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'business-insights-related-post');
                                        $url = $thumb['0']; ?>
                                        <a href="<?php the_permalink(); ?>" class="bg-image bg-image-1">
                                            <img src="<?php echo esc_url($url); ?>" alt="<?php the_title_attribute(); ?>">
                                        </a>
                                    <?php } ?>
                                    <div class="trend-item">
                                        <span class="number"> <?php echo $count; ?></span>
                                    </div>
                                </div>
                                <div class="article-body">
                                    <div class="post-meta">
                                    <span class="posts-date">
                                        <?php the_date( get_option( 'date_format' ) ); ?>
                                    </div>
                                    <h4 class="secondary-font">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_title(); ?>
                                        </a>
                                    </h4>
                                </div>
                            </article>
                        </li>
                        <?php
                        $count++;
                    endwhile; ?>
                </ul>
            </div>

            <?php wp_reset_postdata(); ?>

        <?php endif; ?>
            <?php echo $args['after_widget'];
        }
    }
endif;

/*author widget*/
if (!class_exists('TWP_Author_Post_widget')) :

    /**
     * Author widget Class.
     *
     * @since 1.0.0
     */
    class TWP_Author_Post_widget extends Business_Insights_Widget_Base
    {

        /**
         * Sets up a new widget instance.
         *
         * @since 1.0.0
         */
        function __construct()
        {
            $opts = array(
                'classname' => 'business_insights_author_widget',
                'description' => esc_html__('Displays authors details in post.', 'business-insights'),
                'customize_selective_refresh' => true,
            );
            $fields = array(
                'title' => array(
                    'label' => esc_html__('Title:', 'business-insights'),
                    'type' => 'text',
                    'class' => 'widefat',
                ),
                'author-name' => array(
                    'label' => esc_html__('Name:', 'business-insights'),
                    'type' => 'text',
                    'class' => 'widefat',
                ),
                'description' => array(
                    'label' => esc_html__('Description:', 'business-insights'),
                    'type' => 'textarea',
                    'class' => 'widget-content widefat'
                ),
                'image_url' => array(
                    'label' => esc_html__('Author Image:', 'business-insights'),
                    'type' => 'image',
                ),
                'url-fb' => array(
                    'label' => esc_html__('Facebook URL:', 'business-insights'),
                    'type' => 'url',
                    'class' => 'widefat',
                ),
                'url-tw' => array(
                    'label' => esc_html__('Twitter URL:', 'business-insights'),
                    'type' => 'url',
                    'class' => 'widefat',
                ),
                'url-gp' => array(
                    'label' => esc_html__('Googleplus URL:', 'business-insights'),
                    'type' => 'url',
                    'class' => 'widefat',
                ),
            );

            parent::__construct('business-insights-author-layout', esc_html__('GW: Author Widget', 'business-insights'), $opts, array(), $fields);
        }

        /**
         * Outputs the content for the current widget instance.
         *
         * @since 1.0.0
         *
         * @param array $args Display arguments.
         * @param array $instance Settings for the current widget instance.
         */
        function widget($args, $instance)
        {

            $params = $this->get_params($instance);

            echo $args['before_widget'];

            if (!empty($params['title'])) {
                echo $args['before_title'] . esc_html( $params['title'] ) . $args['after_title'];
            } ?>

            <!--cut from here-->
            <div class="author-info">
                <div class="author-image">
                    <?php if (!empty($params['image_url'])) { ?>
                        <div class="profile-image text-center bg-image" >
                            <img src="<?php echo esc_url($params['image_url']); ?>">
                        </div>
                    <?php } ?>
                </div> <!-- /#author-image -->
                <div class="author-social">
                    <?php if (!empty($params['url-fb'])) { ?>
                            <a href="<?php echo esc_url($params['url-fb']); ?>" target="_blank">
                                <i class="meta-icon social_facebook"></i>
                            </a>
                    <?php } ?>
                    <?php if (!empty($params['url-tw'])) { ?>
                            <a href="<?php echo esc_url($params['url-tw']); ?>" target="_blank">
                                <i class="social-icon social_twitter"></i>
                            </a>
                    <?php } ?>
                    <?php if (!empty($params['url-gp'])) { ?>
                            <a href="<?php echo esc_url($params['url-gp']); ?>" target="_blank">
                                <i class="social-icon social_googleplus"></i>
                            </a>
                    <?php } ?>
                </div><!-- /#author-social -->
                <div class="author-details text-center">
                    <?php if (!empty($params['author-name'])) { ?>
                        <h3 class="author-name"><?php echo esc_html($params['author-name']); ?></h3>
                    <?php } ?>
                    <?php if (!empty($params['description'])) { ?>
                        <p><?php echo wp_kses_post($params['description']); ?></p>
                    <?php } ?>
                </div> <!-- /#author-details -->
            </div>
            <?php echo $args['after_widget'];
        }
    }
endif;

/*Social widget*/
if (!class_exists('TWP_Social_widget')) :

    /**
     * Social widget Class.
     *
     * @since 1.0.0
     */
    class TWP_Social_widget extends Business_Insights_Widget_Base
    {

        /**
         * Sets up a new widget instance.
         *
         * @since 1.0.0
         */
        function __construct()
        {
            $opts = array(
                'classname' => 'business_insights_social_widget',
                'description' => esc_html__('Displays Social share.', 'business-insights'),
                'customize_selective_refresh' => true,
            );
            $fields = array(
                'title' => array(
                    'label' => esc_html__('Title:', 'business-insights'),
                    'type' => 'text',
                    'class' => 'widefat',
                ),
                'url-fb' => array(
                    'label' => esc_html__('Facebook URL:', 'business-insights'),
                    'type' => 'url',
                    'class' => 'widefat',
                ),
                'url-tw' => array(
                    'label' => esc_html__('Twitter URL:', 'business-insights'),
                    'type' => 'url',
                    'class' => 'widefat',
                ),
                'url-gp' => array(
                    'label' => esc_html__('Googleplus URL:', 'business-insights'),
                    'type' => 'url',
                    'class' => 'widefat',
                ),
                'url-lt' => array(
                    'label' => esc_html__('Linkedin URL:', 'business-insights'),
                    'type' => 'url',
                    'class' => 'widefat',
                ),
                'url-ig' => array(
                    'label' => esc_html__('Instagram URL:', 'business-insights'),
                    'type' => 'url',
                    'class' => 'widefat',
                ),
                'url-pt' => array(
                    'label' => esc_html__('Pinterest URL:', 'business-insights'),
                    'type' => 'url',
                    'class' => 'widefat',
                ),
                'url-sk' => array(
                    'label' => esc_html__('Skype URL:', 'business-insights'),
                    'type' => 'url',
                    'class' => 'widefat',
                ),
                'url-tr' => array(
                    'label' => esc_html__('Tumblr URL:', 'business-insights'),
                    'type' => 'url',
                    'class' => 'widefat',
                ),
                'url-yt' => array(
                    'label' => esc_html__('Youtube URL:', 'business-insights'),
                    'type' => 'url',
                    'class' => 'widefat',
                ),
                'url-vo' => array(
                    'label' => esc_html__('Vimeo URL:', 'business-insights'),
                    'type' => 'url',
                    'class' => 'widefat',
                ),
                'url-wa' => array(
                    'label' => esc_html__('Whatsapp URL:', 'business-insights'),
                    'type' => 'url',
                    'class' => 'widefat',
                ),
                'url-wp' => array(
                    'label' => esc_html__('WordPress URL:', 'business-insights'),
                    'type' => 'url',
                    'class' => 'widefat',
                ),
                'url-db' => array(
                    'label' => esc_html__('Dribbble URL:', 'business-insights'),
                    'type' => 'url',
                    'class' => 'widefat',
                ),
            );

            parent::__construct('business-insights-social-layout', esc_html__('GW: Social Widget', 'business-insights'), $opts, array(), $fields);
        }

        /**
         * Outputs the content for the current widget instance.
         *
         * @since 1.0.0
         *
         * @param array $args Display arguments.
         * @param array $instance Settings for the current widget instance.
         */
        function widget($args, $instance)
        {

            $params = $this->get_params($instance);

            echo $args['before_widget'];

            if (!empty($params['title'])) {
                echo $args['before_title'] . esc_html( $params['title'] ) . $args['after_title'];
            } ?>

            <div class="twp-social-widget">
                <ul class="social-widget-wrapper">
                    <?php if (!empty($params['url-fb'])) { ?>
                        <li>
                            <a href="<?php echo esc_url($params['url-fb']); ?>" target="_blank">
                                <i class="meta-icon social_facebook"></i>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if (!empty($params['url-tw'])) { ?>
                        <li>
                            <a href="<?php echo esc_url($params['url-tw']); ?>" target="_blank">
                                <i class="social-icon social_twitter"></i>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if (!empty($params['url-gp'])) { ?>
                        <li>
                            <a href="<?php echo esc_url($params['url-gp']); ?>" target="_blank">
                                <i class="social-icon social_googleplus"></i>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if (!empty($params['url-lt'])) { ?>
                        <li>
                            <a href="<?php echo esc_url($params['url-lt']); ?>" target="_blank">
                                <i class="social-icon social_linkedin"></i>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if (!empty($params['url-ig'])) { ?>
                        <li>
                            <a href="<?php echo esc_url($params['url-ig']); ?>" target="_blank">
                                <i class="social-icon social_instagram"></i>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if (!empty($params['url-pt'])) { ?>
                        <li>
                            <a href="<?php echo esc_url($params['url-pt']); ?>" target="_blank">
                                <i class="social-icon social_pinterest"></i>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if (!empty($params['url-sk'])) { ?>
                        <li>
                            <a href="<?php echo esc_url($params['url-sk']); ?>" target="_blank">
                                <i class="social-icon social_skype"></i>
                            </a>
                        </li>
                    <?php } ?>

                    <?php if (!empty($params['url-tr'])) { ?>
                        <li>
                            <a href="<?php echo esc_url($params['url-tr']); ?>" target="_blank">
                                <i class="social-icon social_tumblr"></i>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if (!empty($params['url-yt'])) { ?>
                        <li>
                            <a href="<?php echo esc_url($params['url-yt']); ?>" target="_blank">
                                <i class="social-icon social_youtube"></i>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if (!empty($params['url-vo'])) { ?>
                        <li>
                            <a href="<?php echo esc_url($params['url-vo']); ?>" target="_blank">
                                <i class="social-icon social_vimeo"></i>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if (!empty($params['url-wa'])) { ?>
                        <li>
                            <a href="<?php echo esc_url($params['url-wa']); ?>" target="_blank">
                                <i class="social-icon social_whatsapp"></i>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if (!empty($params['url-wp'])) { ?>
                        <li>
                            <a href="<?php echo esc_url($params['url-wp']); ?>" target="_blank">
                                <i class="social-icon social_wordpress"></i>
                            </a>
                        </li>
                    <?php } ?>

                    <?php if (!empty($params['url-db'])) { ?>
                        <li>
                            <a href="<?php echo esc_url($params['url-db']); ?>" target="_blank">
                                <i class="social-icon social_dribbble"></i>
                            </a>
                        </li>
                    <?php } ?>

                </ul>
            </div>
            <?php echo $args['after_widget'];
        }
    }
endif;
