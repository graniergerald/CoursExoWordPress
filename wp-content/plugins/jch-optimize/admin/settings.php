<?php

/**
 * JCH Optimize - Performs several front-end optimizations for fast downloads
 *
 * @package   jchoptimize/wordpress-platform
 * @author    Samuel Marshall <samuel@jch-optimize.net>
 * @copyright Copyright (c) 2020 Samuel Marshall / JCH Optimize
 * @license   GNU/GPLv3, or later. See LICENSE file
 *
 * If LICENSE file missing, see <http://www.gnu.org/licenses/>.
 */

defined('_WP_EXEC') or die('Restricted access');

include JCH_PLUGIN_DIR . 'admin/initialize.php';
include JCH_PLUGIN_DIR . 'admin/fields/generator.php';
include JCH_PLUGIN_DIR . 'admin/fields/combine-js-css.php';
include JCH_PLUGIN_DIR . 'admin/fields/excludes.php';
include JCH_PLUGIN_DIR . 'admin/fields/miscellaneous.php';
include JCH_PLUGIN_DIR . 'admin/fields/page-cache.php';
include JCH_PLUGIN_DIR . 'admin/fields/optimize-css.php';
include JCH_PLUGIN_DIR . 'admin/fields/css-sprite.php';
include JCH_PLUGIN_DIR . 'admin/fields/http2.php';
include JCH_PLUGIN_DIR . 'admin/fields/lazy-load.php';
include JCH_PLUGIN_DIR . 'admin/fields/cdn.php';
include JCH_PLUGIN_DIR . 'admin/fields/optimize-images.php';


function jch_initialize_settings()
{

	wp_register_style( 'jch-bootstrap-css', JCH_PLUGIN_URL . 'media/css/bootstrap/bootstrap.css', array(), JCH_VERSION );
	wp_register_style( 'jch-admin-css', JCH_PLUGIN_URL . 'media/css/admin.css', array(), JCH_VERSION );
	wp_register_style( 'jch-fonts-css', '//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.css' );
	wp_register_style( 'jch-chosen-css', JCH_PLUGIN_URL . 'media/css/chosen/jquery.chosen.min.css', array(), JCH_VERSION );
	wp_register_style( 'jch-wordpress-css', JCH_PLUGIN_URL . 'media/css/wordpress.css', array(), JCH_VERSION );

	wp_register_script( 'jch-bootstrap-js', JCH_PLUGIN_URL . 'media/js/bootstrap/bootstrap.min.js', array( 'jquery' ), JCH_VERSION, true );
	wp_register_script( 'jch-wordpress-js', JCH_PLUGIN_URL . 'media/js/wordpress.js', array( 'jquery' ), JCH_VERSION, true );
	wp_register_script( 'jch-tabsstate-js', JCH_PLUGIN_URL . 'media/js/bootstrap/tabs-state.js', array( 'jquery' ), JCH_VERSION, true );
	wp_register_script( 'jch-adminutility-js', JCH_PLUGIN_URL . 'media/js/admin-utility.js', array( 'jquery' ), JCH_VERSION, true );
	wp_register_script( 'jch-chosen-js', JCH_PLUGIN_URL . 'media/js/chosen/jquery.chosen.min.js', array( 'jquery' ), JCH_VERSION, true );
	wp_register_script( 'jch-collapsible-js', JCH_PLUGIN_URL . 'media/js/jquery.collapsible.js', array( 'jquery' ), JCH_VERSION, true );

	

	global $jch_redirect;
	$jch_redirect = false;

	check_jch_tasks();
	jch_get_cache_info();
	jch_redirect();
	jch_get_admin_object();

	if ( get_transient( 'jch_notices' ) )
	{
		add_action( 'admin_notices', 'jch_send_notices' );
	}

### Combine CSS/JS Tab ###

	//Combine CSS/Js Section
	add_settings_section( 'jch_basic_pre', '', 'jch_basic_pre_section_text', 'jch-sections' );
	add_settings_field( 'jch_options_combine_files_enable', __( 'Enable', 'jch-optimize' ), 'jch_options_combine_files_enable_string', 'jch-sections', 'jch_basic_pre' );
	add_settings_field( 'jch_options_auto_settings', jch_options_auto_settings_string(true), 'jch_options_auto_settings_string', 'jch-sections', 'jch_basic_pre' );
	add_settings_field( 'jch_options_cache_lifetime', jch_options_cache_lifetime_string(true), 'jch_options_cache_lifetime_string', 'jch-sections', 'jch_basic_pre' );
	add_settings_field( 'jch_options_html_minify_level', jch_options_html_minify_level_string(true), 'jch_options_html_minify_level_string', 'jch-sections', 'jch_basic_pre' );
	add_settings_field( 'jch_options_htaccess', jch_options_htaccess_string(true), 'jch_options_htaccess_string', 'jch-sections', 'jch_basic_pre' );
	add_settings_field( 'jch_options_try_catch', jch_options_try_catch_string(true), 'jch_options_try_catch_string', 'jch-sections', 'jch_basic_pre' );

	//Automatic Settings
	add_settings_section( 'jch_basic_auto', '', 'jch_basic_auto_section_text', 'jch-sections' );
	//Automatic basic settings
	add_settings_field( 'jch_options_auto_basic', '<strong><i>' . __( 'Automatic Basic Settings', 'jch-optimize' ) . '</i></strong><hr>', 'jch_options_spacer_string', 'jch-sections', 'jch_basic_auto' );
	add_settings_field( 'jch_options_css', jch_options_css_string(__( 'Combine CSS Files', 'jch-optimize' )), 'jch_options_css_string', 'jch-sections', 'jch_basic_auto' );
	add_settings_field( 'jch_options_javascript', jch_options_javascript_string(__( 'Combine Javascript Files', 'jch-optimize' )), 'jch_options_javascript_string', 'jch-sections', 'jch_basic_auto' );
	add_settings_field( 'jch_options_gzip', jch_options_gzip_string(__( 'Gzip Combined Files', 'jch-optimize' )), 'jch_options_gzip_string', 'jch-sections', 'jch_basic_auto' );
	add_settings_field( 'jch_options_css_minify', jch_options_css_minify_string(__( 'Minify Combined CSS File', 'jch-optimize' )), 'jch_options_css_minify_string', 'jch-sections', 'jch_basic_auto' );
	add_settings_field( 'jch_options_js_minify', jch_options_js_minify_string(__( 'Minify Combined Javascript File', 'jch-optimize' )), 'jch_options_js_minify_string', 'jch-sections', 'jch_basic_auto' );
	add_settings_field( 'jch_options_html_minify', jch_options_html_minify_string(__( 'Minify HTML', 'jch-optimize' )), 'jch_options_html_minify_string', 'jch-sections', 'jch_basic_auto' );
	//Automatic exclude settings
	add_settings_field( 'jch_options_auto_exclude', '<strong><i>' . __( 'Automatic Exclude Settings', 'jch-optimize' ) . '</i></strong><hr>', 'jch_options_auto_exclude_string', 'jch-sections', 'jch_basic_auto' );
	add_settings_field( 'jch_options_includeAllExtensions',jch_options_includeAllExtensions_string( __( 'Include files from all plugins', 'jch-optimize' )), 'jch_options_includeAllExtensions_string', 'jch-sections', 'jch_basic_auto' );
	//Automatic advanced settings
	add_settings_field( 'jch_options_auto_advanced', '<strong><i>' . __( 'Automatic Advanced Settings', 'jch-optimize' ) . '</i></strong><hr>', 'jch_options_auto_advanced_string', 'jch-sections', 'jch_basic_auto' );
	add_settings_field( 'jch_options_replaceImports', jch_options_replaceImports_string(__( 'Replace @imports in CSS', 'jch-optimize' )), 'jch_options_replaceImports_string', 'jch-sections', 'jch_basic_auto' );
	add_settings_field( 'jch_options_phpAndExternal', jch_options_phpAndExternal_string(__( 'Include PHP files and files from external domains', 'jch-optimize' )), 'jch_options_phpAndExternal_string', 'jch-sections', 'jch_basic_auto' );
	add_settings_field( 'jch_options_inlineStyle', jch_options_inlineStyle_string(__( 'Include inline CSS styles', 'jch-optimize' )), 'jch_options_inlineStyle_string', 'jch-sections', 'jch_basic_auto' );
	add_settings_field( 'jch_options_inlineScripts', jch_options_inlineScripts_string(__( 'Include inline scripts', 'jch-optimize' )), 'jch_options_inlineScripts_string', 'jch-sections', 'jch_basic_auto' );
	add_settings_field( 'jch_options_bottom_js', jch_options_bottom_js_string(__( 'Position javascript file at bottom', 'jch-optimize' )), 'jch_options_bottom_js_string', 'jch-sections', 'jch_basic_auto' );
	add_settings_field( 'jch_options_loadAsynchronous', jch_options_loadAsynchronous_string(__( 'Load combined javascript asynchronously', 'jch-optimize' )), 'jch_options_loadAsynchronous_string', 'jch-sections', 'jch_basic_auto' );

### Exclude CSS/JS Tab ###

	//Exclude Url Section
	add_settings_section( 'jch_url_exclude', '', 'jch_url_exclude_section_text', 'jch-sections' );
	add_settings_field( 'jch_options_url_exclude', jch_options_url_exclude_string(__( 'Exclude these urls', 'jch-optimize' )), 'jch_options_url_exclude_string', 'jch-sections', 'jch_url_exclude' );

	//Exclude preserving execution order section
	add_settings_section( 'jch_exclude_peo', '', 'jch_exclude_peo_section_text', 'jch-sections' );
	add_settings_field( 'jch_options_exclude_css_spacer', '<strong><i>' . __( 'Exclude CSS files and Styles', 'jch-optimize' ) . '</i></strong><hr>', 'jch_options_spacer_string', 'jch-sections', 'jch_exclude_peo' );
	add_settings_field( 'jch_options_excludeCss', jch_options_excludeCss_string(__( 'Exclude these CSS files', 'jch-optimize' )), 'jch_options_excludeCss_string', 'jch-sections', 'jch_exclude_peo' );
	add_settings_field( 'jch_options_excludeCssComponents', jch_options_excludeCssComponents_string(__( 'Exclude CSS files from these plugins', 'jch-optimize' )), 'jch_options_excludeCssComponents_string', 'jch-sections', 'jch_exclude_peo' );
	add_settings_field( 'jch_options_excludeStyles', jch_options_excludeStyles_string(__( 'Exclude individual internal STYLE declarations', 'jch-optimize' )), 'jch_options_excludeStyles_string', 'jch-sections', 'jch_exclude_peo' );
	add_settings_field( 'jch_options_exclude_js_spacer', '<strong><i>' . __( 'Exclude javascript files and scripts', 'jch-optimize' ) . '</i></strong><hr>', 'jch_options_spacer_string', 'jch-sections', 'jch_exclude_peo' );
	add_settings_field( 'jch_options_excludeJs_peo', jch_options_excludeJs_peo_string(__( 'Exclude these javascript files', 'jch-optimize' )), 'jch_options_excludeJs_peo_string', 'jch-sections', 'jch_exclude_peo' );
	add_settings_field( 'jch_options_excludeJsComponents_peo', jch_options_excludeJsComponents_peo_string(__( 'Exclude javascript files from these plugins', 'jch-optimize' )), 'jch_options_excludeJsComponents_peo_string', 'jch-sections', 'jch_exclude_peo' );
	add_settings_field( 'jch_options_excludeScripts_peo', jch_options_excludeScripts_peo_string(__( 'Exclude individual internal SCRIPT declarations', 'jch-optimize' )), 'jch_options_excludeScripts_peo_string', 'jch-sections', 'jch_exclude_peo' );
	add_settings_field( 'jch_options_exclude_all_scripts_spacer', '<strong><i>' . __( 'Exclude all Scripts and Styles', 'jch-optimize' ) . '</i></strong><hr>', 'jch_options_spacer_string', 'jch-sections', 'jch_exclude_peo' );
	add_settings_field( 'jch_options_excludeAllStyles', jch_options_excludeAllStyles_string(__( 'Exclude all STYLE declarations', 'jch-optimize' )), 'jch_options_excludeAllStyles_string', 'jch-sections', 'jch_exclude_peo' );
	add_settings_field( 'jch_options_excludeAllScripts', jch_options_excludeAllScripts_string(__( 'Exclude all SCRIPT declarations', 'jch-optimize' )), 'jch_options_excludeAllScripts_string', 'jch-sections', 'jch_exclude_peo' );

	//Exclude ignoring execution order section
	add_settings_section( 'jch_exclude_ieo', '', 'jch_exclude_ieo_section_text', 'jch-sections' );
	add_settings_field( 'jch_options_exclude__ieo_js_spacer', '<strong><i>' . __( 'Exclude javascript files and scripts', 'jch-optimize' ) . '</i></strong><hr>', 'jch_options_spacer_string', 'jch-sections', 'jch_exclude_ieo' );
	add_settings_field( 'jch_options_excludeJs', jch_options_excludeJs_string(__( 'Exclude these javascript files', 'jch-optimize' )), 'jch_options_excludeJs_string', 'jch-sections', 'jch_exclude_ieo' );
	add_settings_field( 'jch_options_excludeJsComponents', jch_options_excludeJsComponents_string(__( 'Exclude javascript files from these plugins', 'jch-optimize' )), 'jch_options_excludeJsComponents_string', 'jch-sections', 'jch_exclude_ieo' );
	add_settings_field( 'jch_options_excludeScripts', jch_options_excludeScripts_string(__( 'Exclude individual internal SCRIPT declarations', 'jch-optimize' )), 'jch_options_excludeScripts_string', 'jch-sections', 'jch_exclude_ieo' );
	//Don't move to bottom section
	add_settings_section( 'jch_dontmove', '', 'jch_dontmove_section_text', 'jch-sections' );
	add_settings_field( 'jch_options_dontmoveJs', jch_options_dontmoveJs_string(__( 'Javascript files', 'jch-optimize' )), 'jch_options_dontmoveJs_string', 'jch-sections', 'jch_dontmove' );
	add_settings_field( 'jch_options_dontmoveScripts', jch_options_dontmoveScripts_string(__('Inline scripts', 'jch-optimize')), 'jch_options_dontmoveScripts_string', 'jch-sections', 'jch_dontmove' );

### Miscellaneous Tab ###

	//Miscellaneous section
	add_settings_section( 'jch_basic_misc', '', 'jch_basic_misc_section_text', 'jch-sections' );
	add_settings_field( 'jch_options_pro_downloadid', jch_options_pro_downloadid_string(__( 'Download ID', 'jch-optimize' )), 'jch_options_pro_downloadid_string', 'jch-sections', 'jch_basic_misc' );
	add_settings_field( 'jch_options_utility_settings', __( 'Utility Settings', 'jch-optimize' ), 'jch_options_utility_settings_string', 'jch-sections', 'jch_basic_misc' );
	add_settings_field( 'jch_options_order_plugin', jch_options_order_plugin_string(__( 'Order plugin', 'jch-optimize' )), 'jch_options_order_plugin_string', 'jch-sections', 'jch_basic_misc' );
	add_settings_field( 'jch_options_debug', jch_options_debug_string(__( 'Debug plugin', 'jch-optimize' )), 'jch_options_debug_string', 'jch-sections', 'jch_basic_misc' );
	add_settings_field( 'jch_options_disable_logged_in_users', jch_options_disable_logged_in_users_string(__( 'Disable logged in Users', 'jch-optimize' )), 'jch_options_disable_logged_in_users_string', 'jch-sections', 'jch_basic_misc' );

	//Image Attributes section
	add_settings_section( 'jch_img_attributes', '', 'jch_img_attributes_section_text', 'jch-sections' );
	add_settings_field( 'jch_img_attributes_enable', __( 'Enable', 'jch-optimize' ), 'jch_options_img_attributes_enable_string', 'jch-sections', 'jch_img_attributes' );

### Page Cache Tab ###

	//Page Cache Section
	add_settings_section( 'jch_page_cache', '', 'jch_page_cache_section_text', 'jch-sections' );
	add_settings_field( 'jch_options_cache_enable', jch_options_cache_enable_string(__( 'Enable', 'jch-optimize' )), 'jch_options_cache_enable_string', 'jch-sections', 'jch_page_cache' );
	add_settings_field( 'jch_options_pro_cache_platform',jch_options_pro_cache_platform_string( __( 'Platform Specific', 'jch-optimize' )), 'jch_options_pro_cache_platform_string', 'jch-sections', 'jch_page_cache' );
	add_settings_field( 'jch_options_page_cache_lifetime', jch_options_page_cache_lifetime_string(__( 'Cache lifetime', 'jch-optimize' )), 'jch_options_page_cache_lifetime_string', 'jch-sections', 'jch_page_cache' );
	add_settings_field( 'jch_options_cache_exclude', jch_options_cache_exclude_string(__( 'Exclude urls', 'jch-optimize' )), 'jch_options_cache_exclude_string', 'jch-sections', 'jch_page_cache' );

### Optimize CSS ###

    //Optimize Google Fonts
    add_settings_section('jch_optimize_gfont', '', 'jch_optimize_gfont_section_text', 'jch-sections');
    add_settings_field('jch_options_pro_optimize_gfont_enable', __('Enable', 'jch-optimize'), 'jch_options_pro_optimize_gfont_enable_string', 'jch-sections', 'jch_optimize_gfont');

	//Optimize CSS Delivery Section
	add_settings_section( 'jch_pro_ocd', '', 'jch_pro_ocd_section_text', 'jch-sections' );
	add_settings_field( 'jch_options_optimizeCssDelivery_enable', __( 'Enable', 'jch-optimize' ), 'jch_options_optimizeCssDelivery_enable_string', 'jch-sections', 'jch_pro_ocd' );
	add_settings_field( 'jch_options_optimizeCssDelivery', __( 'Number of Elements', 'jch-optimize' ), 'jch_options_optimizeCssDelivery_string', 'jch-sections', 'jch_pro_ocd' );
	add_settings_field( 'jch_options_pro_remove_unused_css', jch_options_pro_remove_unused_css_string(__( 'Remove unused CSS', 'jch-optimize' )), 'jch_options_pro_remove_unused_css_string', 'jch-sections', 'jch_pro_ocd' );
	add_settings_field( 'jch_options_pro_dynamic_selectors', jch_options_pro_dynamic_selectors_string(__( 'Dynamic Selectors', 'jch-optimize' )), 'jch_options_pro_dynamic_selectors_string', 'jch-sections', 'jch_pro_ocd' );

### Sprite Generator Tab ###

	//Sprite Generator Section
	add_settings_section( 'jch_sprite_manual', '', 'jch_sprite_manual_section_text', 'jch-sections' );
	add_settings_field( 'jch_options_csg_enable', __( 'Enable', 'jch-optimize' ), 'jch_options_csg_enable_string', 'jch-sections', 'jch_sprite_manual' );
	add_settings_field( 'jch_options_csg_direction', jch_options_csg_direction_string(__( 'Sprite Build Direction', 'jch-optimize' )), 'jch_options_csg_direction_string', 'jch-sections', 'jch_sprite_manual' );
	add_settings_field( 'jch_options_csg_wrap_images', jch_options_csg_wrap_images_string(__( 'Wrap Images', 'jch-optimize' )), 'jch_options_csg_wrap_images_string', 'jch-sections', 'jch_sprite_manual' );
	add_settings_field( 'jch_options_csg_exclude_images', jch_options_csg_exclude_images_string(__( 'Exclude these images from the sprite', 'jch-optimize' )), 'jch_options_csg_exclude_images_string', 'jch-sections', 'jch_sprite_manual' );
	add_settings_field( 'jch_options_csg_include_images', jch_options_csg_include_images_string(__( 'Include these images in the sprite', 'jch-optimize' )), 'jch_options_csg_include_images_string', 'jch-sections', 'jch_sprite_manual' );


### Http2 Push Tab ###

	//Http2 Section
	add_settings_section( 'jch_pro_http2_push', '', 'jch_pro_http2_push_section_text', 'jch-sections' );
	add_settings_field( 'jch_options_http2_push_enable', __( 'Enable', 'jch-optimize' ), 'jch_options_http2_push_enable_string', 'jch-sections', 'jch_pro_http2_push' );
	add_settings_field( 'jch_options_pro_http2_exclude_deferred', jch_options_pro_http2_exclude_deferred_string(__( 'Exclude deferred files', 'jch-optimize' )), 'jch_options_pro_http2_exclude_deferred_string', 'jch-sections', 'jch_pro_http2_push' );
	add_settings_field( 'jch_options_pro_http2_push_cdn', jch_options_pro_http2_push_cdn_string(__( 'Preload CDN files', 'jch-optimize' )), 'jch_options_pro_http2_push_cdn_string', 'jch-sections', 'jch_pro_http2_push' );
	add_settings_field( 'jch_options_pro_http2_file_types', __( 'File types', 'jch-optimize' ), 'jch_options_pro_http2_file_types_string', 'jch-sections', 'jch_pro_http2_push' );
	add_settings_field('jch_options_pro_http2_include', jch_options_pro_http2_include_string(__('Include Files', 'jch-optimize')), 'jch_options_pro_http2_include_string', 'jch-sections', 'jch_pro_http2_push');
	add_settings_field( 'jch_options_pro_http2_exclude', jch_options_pro_http2_exclude_string(__( 'Exclude files', 'jch-optimize' )), 'jch_options_pro_http2_exclude_string', 'jch-sections', 'jch_pro_http2_push' );

### Lazy-Load Tab ###
	
	//Lazy-load Section
	add_settings_section( 'jch_pro_lazyload', '', 'jch_pro_lazyload_section_text', 'jch-sections' );
	add_settings_field( 'jch_options_lazyload_enable', __( 'Enable', 'jch-optimize' ), 'jch_options_lazyload_enable_string', 'jch-sections', 'jch_pro_lazyload' );
	add_settings_field( 'jch_options_pro_lazyload_iframe', jch_options_pro_lazyload_iframe_string(__( 'Lazy load iframes', 'jch-optimize' )), 'jch_options_pro_lazyload_iframe_string', 'jch-sections', 'jch_pro_lazyload' );
	add_settings_field( 'jch_options_pro_lazyload_bgimages', jch_options_pro_lazyload_bgimages_string(__( 'Background images', 'jch-optimize' )), 'jch_options_pro_lazyload_bgimages_string', 'jch-sections', 'jch_pro_lazyload' );
	add_settings_field( 'jch_options_pro_lazyload_audiovideo', jch_options_pro_lazyload_audiovideo_string(__( 'Audio/Video', 'jch-optimize' )), 'jch_options_pro_lazyload_audiovideo_string', 'jch-sections', 'jch_pro_lazyload' );
	add_settings_field( 'jch_options_excludeLazyLoad', jch_options_excludeLazyLoad_string(__( 'Exclude these images', 'jch-optimize' )), 'jch_options_excludeLazyLoad_string', 'jch-sections', 'jch_pro_lazyload' );
	add_settings_field( 'jch_options_pro_excludeLazyLoadFolder', jch_options_pro_excludeLazyLoadFolder_string(__( 'Exclude these folders', 'jch-optimize' )), 'jch_options_pro_excludeLazyLoadFolder_string', 'jch-sections', 'jch_pro_lazyload' );
	add_settings_field( 'jch_options_pro_excludeLazyLoadClass', jch_options_pro_excludeLazyLoadClass_string(__( 'Exclude these classes', 'jch-optimize' )), 'jch_options_pro_excludeLazyLoadClass_string', 'jch-sections', 'jch_pro_lazyload' );
	add_settings_field( 'jch_options_pro_lazyload_effects', jch_options_pro_lazyload_effects_string(__( 'Enable effects', 'jch-optimize' )), 'jch_options_pro_lazyload_effects_string', 'jch-sections', 'jch_pro_lazyload' );
	add_settings_field( 'jch_options_lazyload_autosize', jch_options_lazyload_autosize_string(__( 'Autosize images', 'jch-optimize' )), 'jch_options_lazyload_autosize_string', 'jch-sections', 'jch_pro_lazyload' );

### CDN Tab ###
	
	//CDN Section
	add_settings_section( 'jch_pro_cookielessdomain', '', 'jch_pro_cookielessdomain_section_text', 'jch-sections' );
	add_settings_field( 'jch_options_cookielessdomain_enable', __( 'Enable', 'jch-optimize' ), 'jch_options_cookielessdomain_enable_string', 'jch-sections', 'jch_pro_cookielessdomain' );
	add_settings_field('jch_options_pro_cdn_preconnect', jch_options_pro_cdn_preconnect_string(__('Preconnect CDNs', 'jch-optimize')), 'jch_options_pro_cdn_preconnect_string', 'jch-sections', 'jch_pro_cookielessdomain');
	add_settings_field( 'jch_options_cdn_scheme', jch_options_cdn_scheme_string(__( 'CDN scheme', 'jch-optimize' )), 'jch_options_cdn_scheme_string', 'jch-sections', 'jch_pro_cookielessdomain' );
	add_settings_field( 'jch_options_cookielessdomain', __( 'Domain 1', 'jch-optimize' ), 'jch_options_cookielessdomain_string', 'jch-sections', 'jch_pro_cookielessdomain' );
	add_settings_field( 'jch_options_staticfiles', __( 'Static Files 1', 'jch-optimize' ), 'jch_options_staticfiles_string', 'jch-sections', 'jch_pro_cookielessdomain' );
	add_settings_field( 'jch_options_pro_customcdnextensions', jch_options_pro_customcdnextensions_string(__( 'Custom Extensions', 'jch-optimize' )), 'jch_options_pro_customcdnextensions_string', 'jch-sections', 'jch_pro_cookielessdomain' );
	add_settings_field( 'jch_options_pro_cookielessdomain_2', __( 'Domain 2', 'jch-optimize' ), 'jch_options_pro_cookielessdomain_2_string', 'jch-sections', 'jch_pro_cookielessdomain' );
	add_settings_field( 'jch_options_pro_staticfiles_2', __( 'Static Files 2', 'jch-optimize' ), 'jch_options_pro_staticfiles_2_string', 'jch-sections', 'jch_pro_cookielessdomain' );
	add_settings_field( 'jch_options_pro_cookielessdomain_3', __( 'Domain 3', 'jch-optimize' ), 'jch_options_pro_cookielessdomain_3_string', 'jch-sections', 'jch_pro_cookielessdomain' );
	add_settings_field( 'jch_options_pro_staticfiles_3', __( 'Static Files 3', 'jch-optimize' ), 'jch_options_pro_staticfiles_3_string', 'jch-sections', 'jch_pro_cookielessdomain' );
	
### Optimize Images Tab ###

	add_settings_section( 'jch_images', '', 'jch_images_section_text', 'jch-sections' );
//        add_settings_field('jch_options_kraken_optimization_level', __('Lossy Optimization', 'jch-optimize'),
//                                                                       'jch_options_kraken_optimization_level_string', 'jch-sections', 'jch_images');
	add_settings_field( 'jch_options_ignore_optimized', jch_options_ignore_optimized_string(__( 'Ignore optimized images', 'jch-optimize' )), 'jch_options_ignore_optimized_string', 'jch-sections', 'jch_images' );

	add_settings_section( 'jch_images_foldertree', '', 'jch_images_foldertree_section_text', 'jch-sections' );
	add_settings_field( 'jch_options_optimizeimages', __( 'Optimize Images', 'jch-optimize' ), 'jch_options_optimize_images_string', 'jch-sections', 'jch_images_foldertree' );

	add_settings_section( 'jch_section_end', '', 'jch_section_end_text', 'jch-sections' );
}


