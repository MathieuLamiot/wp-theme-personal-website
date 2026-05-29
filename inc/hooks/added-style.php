<?php
/**
 * CSS related hooks.
 *
 * This file contains hook functions which are related to CSS.
 *
 * @package Business Insights
 */

if (!function_exists('business_insights_trigger_custom_css_action')):

    /**
     * Build and return the theme custom inline CSS string.
     *
     * Returns a plain CSS string (no <style> wrapper — wp_add_inline_style adds that).
     *
     * @since 1.0.0
     * @return string
     */
    function business_insights_trigger_custom_css_action()
    {
        $business_insights_enable_banner_overlay = business_insights_get_option('enable_overlay_option');
        $business_insights_enable_slider_overlay = business_insights_get_option('enable_slider_overlay');
        $business_insights_enable_calback_overlay = business_insights_get_option('enable_calback_overlay');
        $business_insights_enable_testimonial_overlay = business_insights_get_option('enable_testimonial_overlay');
        $business_insights_site_title_font           = business_insights_get_option('site_title_font');

        $css = '';

        if ($business_insights_enable_banner_overlay == 1) {
            $css .= 'body .inner-banner .overlay-bg-enable{';
            $css .= 'filter: alpha(opacity=54);';
            $css .= 'opacity: 0.54;';
            $css .= '}';
        }

        if ($business_insights_enable_slider_overlay == 1) {
            $css .= 'body .single-slide:after{';
            $css .= 'filter: alpha(opacity=54);';
            $css .= 'opacity: 0.54;';
            $css .= '}';
            $css .= 'body .single-slide:after{';
            $css .= 'content: "";';
            $css .= '}';
        }

        if ($business_insights_enable_calback_overlay == 1) {
            $css .= 'body .section-cta .overlay-bg-enable{';
            $css .= 'filter: alpha(opacity=54);';
            $css .= 'opacity: 0.54;';
            $css .= '}';
        }

        if ($business_insights_enable_testimonial_overlay == 1) {
            $css .= 'body .section-testimonial .overlay-bg-enable{';
            $css .= 'filter: alpha(opacity=64);';
            $css .= 'opacity: 0.64;';
            $css .= '}';
        }

        if (!empty($business_insights_site_title_font)) {
            $css .= '@media only screen and (min-width: 992px){';
            $css .= '.site-branding .site-title a{';
            $css .= 'font-size: ' . absint($business_insights_site_title_font) . 'px !important;';
            $css .= '}';
            $css .= '}';
        }

        return $css;
    }

endif;
