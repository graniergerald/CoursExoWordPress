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

### Lazy-load Section ###

function jch_pro_lazyload_section_text()
{
	jch_group_end();

	echo '</div>
  <div class="tab-pane" id="lazyload">';

	$header      = __( 'Lazy Load Images', 'jch-optimize' );
	$description = __( 'Enable to delay the loading of iframes, images and responsive images until they are scrolled into view. This further speeds up the loading of the page and reduces http requests.',
		'jch-optimize' );

	jch_group_start( $header, $description );
}

function jch_options_lazyload_enable_string($title=false)
{
    if($title) {
        $description = __('Enable to delay the loading of images until after the page loads and they are scrolled into view. This further reduces http requests and speeds up the loading of the page.',
            'jch-optimize');

        return jch_gen_description($title, $description);
    }

	echo jch_gen_radio_field( 'lazyload_enable', '0', false );
}

function jch_options_pro_lazyload_iframe_string($title=false)
{
    if($title) {
        $description = __('If enabled will also lazy load IFRAME elements.',
            'jch-optimize');

        return jch_gen_description($title, $description);
    }

	echo jch_gen_radio_field_pro( 'pro_lazyload_iframe', '0', false );
}

function jch_options_pro_lazyload_bgimages_string($title=false)
{
    if($title) {
        $description = __('Will lazyload background images defined in STYLE attributes on HTML elements',
            'jch-optimize');

        return jch_gen_description($title, $description);
    }

	echo jch_gen_radio_field_pro( 'pro_lazyload_bgimages', '0', false );
}

function jch_options_pro_lazyload_audiovideo_string($title=false)
{
    if($title) {
        $description = __('Will lazyload AUDIO and VIDEO elements that are below the fold',
            'jch-optimize');

        return jch_gen_description($title, $description);
    }

	echo jch_gen_radio_field_pro( 'pro_lazyload_audiovideo', '0', false );
}

function jch_options_excludeLazyLoad_string($title=false)
{
    if($title) {
        $description = __('Select or manually add the urls of the images you want to exclude from lazy load.', 'jch-optimize');

        return jch_gen_description($title, $description);
    }

	$option = 'excludeLazyLoad';
	$values = jch_get_field_value( 'lazyload', $option, 'file' );

	echo jch_gen_multiselect_field( $option, $values, false);
}

function jch_options_pro_excludeLazyLoadFolder_string($title=false)
{
    if($title) {
        $description = __('Exclude all the images in the selected folders.', 'jch-optimize');

        return jch_gen_description($title, $description);
    }

	$option = 'pro_excludeLazyLoadFolder';
	$values = jch_get_field_value( 'lazyload', $option, 'folder' );

	echo jch_gen_multiselect_field_pro( $option, $values, false );
}

function jch_options_pro_excludeLazyLoadClass_string($title=false)
{
    if($title) {
        $description = __('Exclude all images that have these classes declared on the <span class="notranslate">&lt;img&gt;</span> element', 'jch-optimize');

        return jch_gen_description($title, $description);
    }

	$option = 'pro_excludeLazyLoadClass';
	$values = jch_get_field_value( 'lazyload', $option, 'class' );

	echo jch_gen_multiselect_field_pro( $option, $values, false );
}

function jch_options_pro_lazyload_effects_string($title=false)
{
    if($title) {
        $description = __('Enable to use fade-in effects when images are scrolled into view', 'jch-optimize');

        return jch_gen_description($title, $description);
    }

	echo jch_gen_radio_field_pro( 'pro_lazyload_effects', '0', false );
}

function jch_options_lazyload_autosize_string($title=false)
{
    if($title) {
        $description = __('If the size of the images seem incorrect or if you see empty spaces under the images after enabling Lazy-load, try enabling this setting to correct that', 'jch-optimize');

        return jch_gen_description($title, $description);
    }

	echo jch_gen_radio_field( 'lazyload_autosize', '0', false);

}

