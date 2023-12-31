<?php
/**
 * Collection of other function file.
 */
require get_template_directory().'/inc/common-functions-hooks.php';

/**
 * Tgmpa plugin activation.
 */
require get_template_directory().'/assets/libraries/TGM-Plugin/class-tgm-plugin-activation.php';

/*widget init*/
require get_template_directory().'/inc/widget-init.php';

/*widgets init*/
require get_template_directory().'/inc/widgets/widgets.php';

/*layout meta*/
require get_template_directory().'/inc/hooks/layout-meta/layout-meta.php';

/*header css*/
require get_template_directory().'/inc/hooks/added-style.php';

/*section hook init*/
require get_template_directory().'/inc/hooks/breadcrumb.php';
require get_template_directory().'/inc/hooks/header-inner-page.php';
require get_template_directory().'/inc/hooks/slider.php';
require get_template_directory().'/inc/hooks/intro-section.php';
require get_template_directory().'/inc/hooks/callback-action.php';
require get_template_directory().'/inc/hooks/process-section.php';
require get_template_directory().'/inc/hooks/testimonial.php';
require get_template_directory().'/inc/hooks/contact.php';
require get_template_directory().'/inc/hooks/latest-blog.php';
