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

### Optimize Google Font Section ###

function jch_optimize_gfont_section_text()
{
    jch_group_end();

    echo '</div>
  <div class="tab-pane" id="optimize-css">';

    $header = __('Optimize Google Fonts', 'jch-optimize');
    $description = __('Will speed up the loading of Google fonts to reduce Largest Contentful Paint on Google PageSpeed Insights <span class="label label-important">New!</span>', 'jch-optimize');

    jch_group_start($header, $description);
}

function jch_options_pro_optimize_gfont_enable_string()
{
    echo jch_gen_radio_field_pro('pro_optimize_gfont_enable', '0', false);
}

### Optimize Css Section ###

function jch_pro_ocd_section_text()
{
	jch_group_end();

	$header      = __( 'Optimize CSS Delivery', 'jch-optimize' );
	$description = __( 'The plugin will attempt to extract the critical CSS that is required to format the page above the fold and put this in a <span class="notranslate">&lt;style&gt;</span> element inside the <span class="notranslate">&lt;head&gt;</span> section of the HTML to prevent \'render-blocking\'. The combined CSS will then be loaded asynchronously via javascript. Select the number of HTML elements from the top of the page that you want the plugin to find the critical CSS for. The smaller the number, the faster your site but you might see some jumping of the page if the number is too small.',
		'jch-optimize' );

	jch_group_start( $header, $description );
}

function jch_options_optimizeCssDelivery_enable_string()
{
	echo jch_gen_radio_field( 'optimizeCssDelivery_enable', '0', '' );
}

function jch_options_optimizeCssDelivery_string()
{
	$values = array( '200' => '200', '400' => '400', '600' => '600', '800' => '800' );

	echo jch_gen_select_field( 'optimizeCssDelivery', '200', $values, '' );
}

function jch_options_pro_remove_unused_css_string($title=false)
{
    if($title) {
        $description = __('Will attempt to remove any CSS from the combined file that is not being used on the page. NOTE: This setting will remove the CSS for dynamic content. Manually place CSS selectors that targets the dynamic elements you want rendered below.');

        return jch_gen_description($title, $description);
    }

	echo jch_gen_radio_field_pro( 'pro_remove_unused_css', '0', false );
}

function jch_options_pro_dynamic_selectors_string($title=false)
{
    if($title) {
        $description = __('Add CSS selectors here that targets dynamic elements to ensure CSS rule-sets containing these selectors gets added to the combined CSS files when \'Remove unused CSS\' is enabled. These are normally classes that are added to elements dynamically.');

        return jch_gen_description($title, $description);
    }

	$option = 'pro_dynamic_selectors';
	$values = jch_get_field_value( 'dynamicselectors', $option, 'style' );

	echo jch_gen_multiselect_field_pro( $option, $values, false );
}


