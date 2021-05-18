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

### CDN Section ###

function jch_pro_cookielessdomain_section_text()
{
	jch_group_end();

	echo '</div>
  <div class="tab-pane" id="cdn">';


	$header      = __( 'CDN/Cookieless Domain', 'jch-optimize' );
	$description = __( 'Enter your CDN or cookieless domain here. The plugin will load all static files including background images, combined javascript and css files, and generated sprite from this domain. This requires that this domain is already set up and points to your site root. You can also use multiple domains and the plugin will alternate the domains among the static files. You can also select the file types that you want to be loaded over these domains.',
		'jch-optimize' );

	jch_group_start( $header, $description );
}

function jch_options_cookielessdomain_enable_string()
{
	echo jch_gen_radio_field( 'cookielessdomain_enable', '0', '' );
}

function jch_options_pro_cdn_preconnect_string($title=false)
{
    if($title)
    {
        $description = __('Add preconnect resource hints in the HTML for all your CDN domains to establish early connections and speed up loading of resources from your CDN.', 'jch-optimize');

        return jch_gen_description($title, $description, true);
    }

    echo jch_gen_radio_field_pro('pro_cdn_preconnect', '1', '');
}

function jch_options_cdn_scheme_string($title=false)
{
    if($title) {
        $description = __('Select the scheme that you want prepended to the CDN/Cookieless domain', 'jch-optimize');

        return jch_gen_description($title, $description);
    }

	$values      = array(
		'0' => __( 'scheme relative', 'jch-optimize' ),
		'1' => __( 'http', 'jch-optimize' ),
		'2' => __( 'https', 'jch-optimize' )
	);

	echo jch_gen_select_field( 'cdn_scheme', '0', $values, false, $class = '' );
}

function jch_options_cookielessdomain_string()
{
	echo jch_gen_text_field( 'cookielessdomain', '', '', '', '30' );
}

function jch_get_static_files_options()
{
	return array(
		'css'   => 'css',
		'png'   => 'png',
		'gif'   => 'gif',
		'ico'   => 'ico',
		'pdf'   => 'pdf',
		'js'    => 'js',
		'jpe?g' => 'jp(e)g',
		'bmp'   => 'bmp',
		'webp'  => 'webp',
		'svg'   => 'svg'
	);
}

function jch_options_staticfiles_string()
{
	$values = jch_get_static_files_options();

	echo jch_gen_checkboxes_field( 'staticfiles', $values, 'checkboxes' );
}

function jch_options_pro_customcdnextensions_string($title=false)
{
    if($title) {
        $description = __('To add custom extensions of file types to be loaded over CDN on Domain 1, type the extension in the textbox and press the \'Add item\' button');

        return jch_gen_description($title, $description);
    }

	$option = 'pro_customcdnextensions';
	$values = jch_get_field_value( 'customextension', $option, 'file' );

	echo jch_gen_multiselect_field_pro( $option, $values, false );
}

function jch_options_pro_cookielessdomain_2_string($title=false)
{

	echo jch_gen_text_field_pro( 'pro_cookielessdomain_2', '', '', '', '30' );
}

function jch_options_pro_staticfiles_2_string()
{
	$values = jch_get_static_files_options();

	echo jch_gen_checkboxes_field_pro( 'pro_staticfiles_2', $values, 'checkboxes' );
}

function jch_options_pro_cookielessdomain_3_string()
{
	echo jch_gen_text_field_pro( 'pro_cookielessdomain_3', '', '', '', '30' );
}

function jch_options_pro_staticfiles_3_string()
{
	$values = jch_get_static_files_options();

	echo jch_gen_checkboxes_field_pro( 'pro_staticfiles_3', $values, 'checkboxes' );
}


function jch_section_end_text()
{
	echo '</div>';
}
