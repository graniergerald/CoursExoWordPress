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

### Http2 Push section ###

function jch_pro_http2_push_section_text()
{
    jch_group_end();

    echo '</div>
  <div class="tab-pane" id="http2">';

    $header = __('Http/2 Push', 'jch-optimize');
    $description = __('Plugin will send appropriate preload headers to your server to push resource files before the browser requests them and so speed up the loading of the page. Please note this only works if http/2 is enabled on the server', 'jch-optimize');

    jch_group_start($header, $description);
}

function jch_options_http2_push_enable_string()
{

    echo jch_gen_radio_field('http2_push_enable', '0', '');
}

function jch_options_pro_http2_exclude_deferred_string($title = false)
{
    if ($title) {
        $description = __('Will exclude javascript files that are deferred or loaded asynchronously, deferred CSS file in Optimize CSS Delivery feature, and images that are lazy-loaded. This can help reduce bandwidth and speed up first paint rendering.', 'jch-optimize');

        return jch_gen_description($title, $description);
    }

    echo jch_gen_radio_field_pro('pro_http2_exclude_deferred', '1', false);
}

function jch_options_pro_http2_push_cdn_string($title = false)
{
    if ($title) {
        $description = __('Files loaded over CDN domains in the CDN feature will also be added to the Link header for preload', 'jch-optimize');

        return jch_gen_description($title, $description);
    }

    echo jch_gen_radio_field_pro('pro_http2_push_cdn', '0', false);
}

function jch_options_pro_http2_file_types_string()
{
    $values = array(
        'style' => 'style',
        'script' => 'script',
        'font' => 'font',
        'image' => 'image'
    );

    echo jch_gen_checkboxes_field_pro('pro_http2_file_types', $values, 'checkboxes');
}

function jch_options_pro_http2_include_string($title = false)
{
    if ($title) {
        $description = __('Sometimes some files are dynamically loaded so you can add these files here. Be sure any file added here are loaded on all pages and that you include the full file path including any queries etc. Only the following file extensions are supported: .js, .css, .webp, .gif, .png, .jpg, .woff, .woff2', 'jch-optimize');

        return jch_gen_description($title, $description, true);
    }

    $option = 'pro_http2_include';
    $values = jch_get_field_value('', $option, 'file');

    echo jch_gen_multiselect_field_pro($option, $values, false);
}

function jch_options_pro_http2_exclude_string($title = false)
{
    if ($title) {
        $description = __('If you see any warnings in the browser console that the preloaded files weren\'t used within a few seconds you can exclude these files here', 'jch-optimize');

        return jch_gen_description($title, $description);
    }

    $option = 'pro_http2_exclude';
    $values = jch_get_field_value('', $option, 'file');

    echo jch_gen_multiselect_field_pro($option, $values, false);
}

