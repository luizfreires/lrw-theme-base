<?php
/**
 * Theme functions includes
 *
 * This file is used to include files with auxiliary
 * functions and settings of the core theme
 *
 * @package Odin
 *
 * Note: Do not add any custom code here. Please use a child theme so that your customizations aren't lost during updates.
 * http://codex.wordpress.org/Child_Themes
 */

/**
 * Odin Classes.
 */
require_once get_template_directory() . '/core/classes/class-bootstrap-nav.php';
require_once get_template_directory() . '/core/classes/class-shortcodes.php';
require_once get_template_directory() . '/core/classes/class-thumbnail-resizer.php';
// require_once get_template_directory() . '/core/classes/class-theme-options.php';
// require_once get_template_directory() . '/core/classes/class-options-helper.php';
// require_once get_template_directory() . '/core/classes/class-post-type.php';
// require_once get_template_directory() . '/core/classes/class-taxonomy.php';
// require_once get_template_directory() . '/core/classes/class-metabox.php';
// require_once get_template_directory() . '/core/classes/class-post-form.php';
// require_once get_template_directory() . '/core/classes/class-user-meta.php';
// require_once get_template_directory() . '/core/classes/class-post-status.php';
// require_once get_template_directory() . '/core/classes/class-term-meta.php';

/**
 * Odin Widgets.
 */
require_once get_template_directory() . '/core/classes/widgets/class-widget-contact.php';
require_once get_template_directory() . '/core/classes/widgets/class-widget-embed.php';
require_once get_template_directory() . '/core/classes/widgets/class-widget-excerpt-page.php';
require_once get_template_directory() . '/core/classes/widgets/class-widget-latest-post.php';
require_once get_template_directory() . '/core/classes/widgets/class-widget-like-box.php';
require_once get_template_directory() . '/core/classes/widgets/class-widget-social.php';
require_once get_template_directory() . '/core/classes/widgets/class-widget-twitter.php';

/**
 * Add Theme Functions
 */
require_once get_template_directory() . '/inc/theme-functions.php';

/**
 * Core Helpers.
 */
require_once get_template_directory() . '/core/helpers.php';

/**
 * WP Custom Admin.
 */
require_once get_template_directory() . '/inc/admin.php';

/**
 * Comments loop.
 */
require_once get_template_directory() . '/inc/comments-loop.php';

/**
 * Add Scripts Site
 */
require_once get_template_directory() . '/inc/scripts.php';

/**
 * WP optimize functions.
 */
require_once get_template_directory() . '/inc/optimize.php';

/**
 * Custom template tags.
 */
require_once get_template_directory() . '/inc/template-tags.php';

/**
 * Required Plugins
 */
if ( is_admin() ) {
    require_once get_template_directory() . '/core/plugins/class-tgm-plugin-activation.php';
    require_once get_template_directory() . '/core/plugins/register.php';
}

/**
 * WooCommerce compatibility files.
 */
if ( is_woocommerce_activated() ) {
    add_theme_support( 'woocommerce' );
    require get_template_directory() . '/inc/woocommerce/hooks.php';
    require get_template_directory() . '/inc/woocommerce/functions.php';
    require get_template_directory() . '/inc/woocommerce/template-tags.php';
}