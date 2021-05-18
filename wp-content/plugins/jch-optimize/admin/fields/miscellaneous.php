<?php

use JchOptimize\Core\Admin;
use JchOptimize\Platform\Paths;
use JchOptimize\Platform\Utility;

defined('_WP_EXEC') or die('Restricted access');

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

### Miscellaneous Settings ###

function jch_basic_misc_section_text()
{
	jch_group_end();

	echo '</div>
  <div class="tab-pane" id="misc">';

	$header = __( 'Miscellaneous Settings', 'jch-optimize' );

	jch_group_start( $header );
}

function jch_options_pro_downloadid_string($title=false)
{
    if($title) {
        $description = __('Enter your download ID to enable automatic updates of the pro version. Log into your account on the jch-optimize.net website and access the download id from the \'My Account -> My Download ID\' menu item',
            'jch-optimize');

        return jch_gen_description($title, $description);
    }

	echo jch_gen_text_field( 'pro_downloadid', '', false, '', '40' );
}

function jch_options_utility_settings_string()
{
	$attribute = jch_get_cache_info();

	$description = '';

	$aButtons = Admin::getUtilityIcons();

	$aButtons[4]['link'] = Paths::adminController( 'orderplugin' );;
	$aButtons[4]['icon']    = 'fa-sort-numeric-asc';
	$aButtons[4]['color']   = '#278EB1';
	$aButtons[4]['text']    = Utility::translate( 'Order Plugin' );
	$aButtons[4]['script']  = '';
	$aButtons[4]['class']   = 'enabled';
	$aButtons[4]['tooltip'] = Utility::translate( 'The published order of the plugin is important! When you click on this icon, it will attempt to order the plugin correctly.' );

	ksort( $aButtons );

	echo '<div style="display: -webkit-flex; display: -ms-flex; display: -moz-flex; display: flex;">';
	echo jch_gen_button_icons( $aButtons, $description, $attribute );
}

function jch_options_order_plugin_string($title=false)
{
    if($title) {
        $description = __('The plugin will automatically set the execution order of plugins so to ensure compatibility with other plugins.', 'jch-optimize');

        return jch_gen_description($title, $description);
    }

	echo jch_gen_radio_field( 'order_plugin', '1', false);
}

function jch_options_debug_string($title=false)
{
    if($title) {
        $description = __('This option will add the \'commented out\' url of the individual files inside the combined file above the contents that came from that file. This is useful when configuring the plugin and trying to resolve conflicts. This will also add a <span class="notranslate">Profiler</span> menu to the <span class="notranslate">AdminBar</span> so you can review the times that the plugin methods take to run.',
            'jch-optimize');

        return jch_gen_description($title, $description);
    }

	echo jch_gen_radio_field( 'debug', '0', false );
}

function jch_options_disable_logged_in_users_string($title=false)
{
    if($title) {
        $description = __('When enabled the plugin will be disabled for all users that are logged in', 'jch-optimize');

        return jch_gen_description($title, $description);
    }

	echo jch_gen_radio_field( 'disable_logged_in_users', '0', false);

}

### Image Attributes ###


function jch_img_attributes_section_text()
{
	jch_group_end();

	$header      = __( 'Add Image Attributes', 'jch-optimize' );
	$description = __( 'When enabled, the plugin will add missing width and height attributes to <span class="notranslate">&lt;img/&gt;</span>  elements',
		'jch-optimize' );

	jch_group_start( $header, $description );
}

function jch_options_img_attributes_enable_string()
{
    echo jch_gen_radio_field('img_attributes_enable', '0', '');
}
