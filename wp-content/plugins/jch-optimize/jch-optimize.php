<?php

/**
 * Plugin Name: JCH Optimize
 * Plugin URI: http://www.jch-optimize.net/
 * Description: JCH Optimize performs several front-end optimizations to your webpages for fast downloads
 * Version: 2.8.1
 * Author: Samuel Marshall
 * License: GNU/GPLv3
 * Text Domain: jch-optimize
 * Domain Path: /languages
 */

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

$jch_backend     = filter_input( INPUT_GET, 'jchbackend', FILTER_SANITIZE_STRING );
$jch_no_optimize = false;

define( '_WP_EXEC', '1' );

use JchOptimize\Platform\Plugin;
use JchOptimize\Platform\Uri;
use JchOptimize\Platform\Cache;
use JchOptimize\Platform\Utility;
use JchOptimize\Core\Helper;
use JchOptimize\Core\Optimize;
use JchOptimize\Core\Logger;
use JchOptimize\Core\PageCache;
use JchOptimize\Core\Admin;

define( 'JCH_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'JCH_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );


if ( ! defined( 'JCH_VERSION' ) )
{
	define( 'JCH_VERSION', '2.8.1' );
}

require_once( JCH_PLUGIN_DIR . 'autoload.php' );

$params = Plugin::getPluginParams();

//Handles activation routines
include_once JCH_PLUGIN_DIR . 'jchplugininstaller.php';
$JchPluginInstaller = new JchPluginInstaller();
register_activation_hook( __FILE__, array( $JchPluginInstaller, 'activate' ) );

if ( ! file_exists( dirname( __FILE__ ) . '/dir.php' ) )
{
	$JchPluginInstaller->activate();
}

if ( is_admin() )
{
	require_once( JCH_PLUGIN_DIR . 'admin/admin.php' );
}
else
{
	$url_exclude = $params->get( 'url_exclude', array() );

	if ( defined( 'WP_USE_THEMES' )
	     && WP_USE_THEMES
	     && $jch_backend != 1
	     && version_compare( PHP_VERSION, '5.3.0', '>=' )
	     && ! defined( 'DOING_AJAX' )
	     && ! defined( 'DOING_CRON' )
	     && ! defined( 'APP_REQUEST' )
	     && ! defined( 'XMLRPC_REQUEST' )
	     && ( ! defined( 'SHORTINIT' ) || ( defined( 'SHORTINIT' ) && ! SHORTINIT ) )
	     && ! Helper::findExcludes( $url_exclude, Uri::getInstance()->toString() ) )
	{
		//Disable NextGen Resource Manager; incompatible with plugin
		//add_filter( 'run_ngg_resource_manager', '__return_false' );

		add_action( 'init', 'jch_init', 0 );

		ob_start( 'jchoptimize' );
	}
}

function jch_init()
{
	Pagecache::initialize();
}

function jch_load_plugin_textdomain()
{
	load_plugin_textdomain( 'jch-optimize', false, basename( dirname( __FILE__ ) ) . '/languages' );
}

add_action( 'plugins_loaded', 'jch_load_plugin_textdomain' );

function jchoptimize( $sHtml )
{
	if ( ! Helper::validateHtml( $sHtml ) )
	{
		return $sHtml;
	}

	//need to check this here, it could be set dynamically
	global $jch_no_optimize;

	$params            = Plugin::getPluginParams();
	$disable_logged_in = $params->get( 'disable_logged_in_users', '0' );

	//Need to call Utility::isGuest after init has been called
	if ( $jch_no_optimize || ( $disable_logged_in && ! Utility::isGuest() ) )
	{
		return $sHtml;
	}

	try
	{
		$sOptimizedHtml = Optimize::optimize( $params, $sHtml );
		Pagecache::store( $sOptimizedHtml );
	}
	catch ( Exception $e )
	{
		Logger::log( $e->getMessage(), $params );

		$sOptimizedHtml = $sHtml;
	}


	return $sOptimizedHtml;
}

add_filter( 'plugin_action_links', 'jch_plugin_action_links', 10, 2 );

function jch_plugin_action_links( $links, $file )
{
	static $this_plugin;

	if ( ! $this_plugin )
	{
		$this_plugin = plugin_basename( __FILE__ );
	}

	if ( $file == $this_plugin )
	{
		$settings_link = '<a href="' . admin_url( 'options-general.php?page=jchoptimize-settings' ) . '">' . __( 'Settings' ) . '</a>';
		array_unshift( $links, $settings_link );
	}

	return $links;
}

function jch_optimize_uninstall()
{
	delete_option( 'jch_options' );

	try
	{
		Cache::deleteCache();
	}
	catch ( \JchOptimize\Core\Exception $e )
	{
	}

	Admin::cleanHtaccess();
}

register_uninstall_hook( __FILE__, 'jch_optimize_uninstall' );

$options = get_option( 'jch_options' );

if ( ! isset( $options['order_plugin'] ) || ( isset( $options['order_plugin'] ) && $options['order_plugin'] ) )
{

	add_action( 'activated_plugin', 'jch_order_plugin' );
	add_action( 'deactivated_plugin', 'jch_order_plugin' );
}

//Adjusts the plugins load order when a plugin is activated
function jch_order_plugin()
{
	$active_plugins = (array) get_option( 'active_plugins', array() );
	$order          = array(
		'wp-rocket/wp-rocket.php',
		'wp-super-cache/wp-cache.php',
		'w2-total-cache/w3-total-cache.php',
		'litespeed-cache/litespeed-cache.php',
		'wp-fastest-cache/wpFastestCache.php',
		'comet-cache/comet-cache.php',
		'hyper-cache/plugin.php',
		'jch-optimize/jch-optimize.php'
	);

	//Get the plugins in $order that are currently activated
	$order_short_list = array_intersect( $order, $active_plugins );
	//Remove plugins in $order_short_list from list of activated plugins
	$active_plugins_slist = array_diff( $active_plugins, $order_short_list );
	//Merge $order with $active_plugins_list
	$ordered_active_plugins = array_merge( $order_short_list, $active_plugins_slist );

	update_option( 'active_plugins', $ordered_active_plugins );

	return true;
}


if ( ! empty( $options['lazyload_enable'] ) )
{
	function jch_load_lazy_images()
	{
		$params = Plugin::getPluginParams();

		wp_register_script( 'jch-lazyloader-js', JCH_PLUGIN_URL . 'media/js/ls.loader.js', array(), JCH_VERSION );
		wp_enqueue_script( 'jch-lazyloader-js' );
		

		if ( $params->get( 'lazyload_autosize', '0' ) )
		{
			wp_register_script( 'jch-lsautosize-js', JCH_PLUGIN_URL . 'media/js/ls.autosize.js', array( 'jch-lazyloader-js' ), JCH_VERSION );
			wp_enqueue_script( 'jch-lsautosize-js' );
		}

		wp_register_script( 'jch-lazyload-js', JCH_PLUGIN_URL . 'media/js/lazysizes.js', array( 'jch-lazyloader-js' ), JCH_VERSION );
		wp_enqueue_script( 'jch-lazyload-js' );
	}

	add_action( 'wp_head', 'jch_load_lazy_images' );
}


