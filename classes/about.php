<?php
/**
 * Business Insights About Page
 * @package Business Insights
 *
 */
if (!class_exists('Business_Insights_About_page')):
    class Business_Insights_About_page
    {
        function __construct()
        {
            add_action('admin_menu', array($this, 'business_insights_backend_menu'), 999);
        }
        // Add Backend Menu
        function business_insights_backend_menu()
        {
            add_theme_page(esc_html__('Business Insights', 'business-insights'), esc_html__('Business Insights', 'business-insights'), 'activate_plugins', 'business-insights-about', array($this, 'business_insights_main_page'), 1);
        }
        // Settings Form
        function business_insights_main_page()
        {
            require get_template_directory() . '/classes/about-render.php';
        }
    }
    new Business_Insights_About_page();
endif;