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

use JchOptimize\Core\Ajax;

include JCH_PLUGIN_DIR . 'admin/form.php';
include JCH_PLUGIN_DIR . 'admin/assets.php';
include JCH_PLUGIN_DIR . 'admin/settings.php';

add_action( 'admin_menu', 'add_jch_optimize_menu' );

function add_jch_optimize_menu()
{
	$hook_suffix = add_options_page( __( 'JCH Optimize Settings', 'jch-optimize' ), 'JCH Optimize', 'manage_options', 'jchoptimize-settings',
		'jch_options_form' );

	add_action( 'admin_enqueue_scripts', 'jch_load_resource_files' );
	add_action( 'admin_head-' . $hook_suffix, 'jch_load_scripts' );
	add_action( 'load-' . $hook_suffix, 'jch_initialize_settings' );
}

add_action( 'admin_init', 'jch_register_options' );

function jch_register_options()
{
	register_setting( 'jch_options', 'jch_options', 'jch_options_validate' );
}

