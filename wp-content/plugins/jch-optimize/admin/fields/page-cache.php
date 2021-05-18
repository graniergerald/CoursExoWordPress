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

function jch_page_cache_section_text()
{
	jch_group_end();

	echo '</div>
  <div class="tab-pane" id="page-cache">';

	$header      = __( 'Page Cache', 'jch-optimize' );
	$description = __( 'The HTML source of the page will be cached to significantly speed up page loads. Deactivate caching while confguring the plugin and be sure to flush cache after making changes to the site.' );

	jch_group_start( $header, $description );
}

function jch_options_cache_enable_string($title=false)
{
    if($title) {
        $description = 'Enable page caching';

        return jch_gen_description($title, $description);
    }

	echo jch_gen_radio_field( 'cache_enable', '0', false);
}

function jch_options_pro_cache_platform_string($title=false)
{
    if($title) {
        $description = 'Enable if HTML output on mobile differs from desktop.';

        return jch_gen_description($title, $description);
    }

	echo jch_gen_radio_field_pro( 'pro_cache_platform', '0', false);
}

function jch_options_page_cache_lifetime_string($title=false)
{
    if($title) {
        $description = __('The period of time for which the page cache will be valid. Be sure to set this lower that the cache lifetime of combined files at all times.');

        return jch_gen_description($title, $description);
    }

	$values = array(
		'900'   => __( '15 min', 'jch-optimize' ),
		'1800'  => __( '30 min', 'jch-optimize' ),
		'3600'  => __( '1 hour', 'jch-optimize' ),
		'10800' => __( '3 hours', 'jch-optimize' ),
		'21600' => __( '6 hours', 'jch-optimize' ),
		'43200' => __( '12 hours', 'jch-optimize' ),
		'86400' => __( '1 day', 'jch-optimize' )
	);

	echo jch_gen_select_field( 'page_cache_lifetime', '900', $values, false, '' );
}

function jch_options_cache_exclude_string($title = false)
{
    if($title) {
        $description = __('Enter any part of a url to exclude that page from caching.', 'jch-optimize');

        return jch_gen_description($title, $description);
    }

	$option = 'cache_exclude';
	$values = jch_get_field_value( 'url', $option, 'file' );

	echo jch_gen_multiselect_field( $option, $values, false );
}
