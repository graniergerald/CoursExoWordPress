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

### Combine Css/Js Section ###

function jch_basic_pre_section_text()
{
    echo '<div class="tab-pane" id="combine-css-js">';

    $header = __('Combine CSS and javascript files', 'jch-optimize');
    $description = __('These settings are concerned with combining CSS and javascript files into one respectively, and the minification of the combined files and the HTML, and also determines where in the HTML the combined files are placed. Refer to the documentation for more information..',
        'jch-optimize');

    jch_group_start($header, $description);
}

function jch_options_combine_files_enable_string()
{
    $description = '';

    echo jch_gen_radio_field('combine_files_enable', '1', $description);
}

function jch_options_auto_settings_string($title = false)
{
    if ($title) {
        $description = __('These six icons represent six preconfigured settings of the options in the \'Automatic Settings Group\'. The level of optimization increases as you go to the right but the risks of conflicts will also increase, so try each in turn and use the highest setting that work for your site. The first, which is the safest, is the default and should work on most websites. These settings do not affect the files/extensions/images etc. that you have excluded.',
            'jch-optimize');

        return  jch_gen_description( __('Automatic Settings', 'jch-optimize'), $description);
    }


    $aButton = jch_get_auto_settings_buttons();

    echo '<div style="display: inline-block;">';
    echo jch_gen_button_icons($aButton, '', '</div>');
}

function jch_options_html_minify_level_string($title = false)
{
    if ($title) {
        $description = __('If \'Minify HTML\' is enabled, this will determine the level of minification. The incremental changes per level are as follows: Basic - Adjoining whitespaces outside of elements are reduced to one whitespace; Advanced - Remove HTML comments, whitespace around block elements and undisplayed elements, Remove unnecessary whitespaces inside of elements and around their attributes; Ultra - Remove redundant attributes, for example, <span class="notranslate">\'text/javascript\'</span>, and remove quotes from around selected attributes (HTML5)',
            'jch-optimize');

        return  jch_gen_description(__('HTML Minification Level', 'jch-optimize'), $description);
    }

    $values = array(
        '0' => __('Basic', 'jch-optimize'),
        '1' => __('Advanced', 'jch-optimize'),
        '2' => __('Ultra', 'jch-optimize')
    );

    echo jch_gen_select_field('html_minify_level', '0', $values, false);
}


function jch_options_htaccess_string($title = false)
{
    if($title) {
        $description = __('By default the combined files will be loaded as static css and javascript files. You would need to include directives in your .htaccess file to gzip these files. You can use PHP files instead that will be gzipped if that option is set. PHP files can be loaded with a query attached with the information to find the combined files, or you can use url rewrite if it\'s available on the server so the files can be masked as static files. If your server prohibits the use of the Options +FollowSymLinks directive in .htaccess files use the respective option.',
            'jch-optimize');

        return  jch_gen_description(__('Combine files delivery', 'jch-optimize'), $description);
    }

    $values = array(
        '0' => __('PHP file with query', 'jch-optimize'),
        '1' => __('PHP using url re-write', 'jch-optimize'),
        '3' => __('PHP using url re-write (Without Options +FollowSymLinks)', 'jch-optimize'),
        '2' => __('Static css and js files', 'jch-optimize')
    );

    echo jch_gen_select_field('htaccess', '2', $values, false, '');
}

function jch_options_try_catch_string($title = false)
{
    if($title) {
        $description = __('If you\'re seeing javascript errors in the console, you can try enabling this option to wrap each javascript file in a <span class="notranslate">\'try-catch\'</span> block to prevent the errors from one file affecting the combined file.',
            'jch-optimize');

        return  jch_gen_description(__('Use try-catch', 'jch-optimize'), $description);
    }

    echo jch_gen_radio_field('try_catch', '1', false);
}

### Automatic Settings Section ###

function jch_basic_auto_section_text()
{
    jch_group_end();

    $header = __('Automatic Settings Group', 'jch-optimize');
    $description = __('The fields in this group are automatically configured with the Automatic Settings - <span class="notranslate">(Minimum - Optimum)</span>. This is highly recommended to avoid conflicts. It is usually not necessary to set these fields manually unless you are troubleshooting a problem, so do not change these settings yourself unless you know what you are doing .',
        'jch-optimize');
    $class = 'class="collapsible" ';

    jch_group_start($header, $description, $class);
}

function jch_options_cache_lifetime_string($title = false)
{
    if ($title) {
        $description = __('The amount of time that the cache will remain valid before the plugin generates a new one. All expired cache will be expunged at this time. Selecting higher values can cause excess cache build-up.');

        return jch_gen_description(__('Cache Lifetime') , $description);
    }

    $values = array(
        '1800' => __('30 min', 'jch-optimize'),
        '3600' => __('1 hour', 'jch-optimize'),
        '10800' => __('3 hours', 'jch-optimize'),
        '21600' => __('6 hours', 'jch-optimize'),
        '43200' => __('12 hours', 'jch-optimize'),
        '86400' => __('1 day', 'jch-optimize')
    );

    echo jch_gen_select_field('cache_lifetime', '900', $values, false, '');
}

function jch_options_spacer_string()
{
    echo '&nbsp;';
}

function jch_options_css_string($title = false)
{
    if ($title) {
        $description = __('This will combine all CSS files into one file and remove all the links to the individual files from the page, replacing it with a link generated by the plugin to the combined file.',
            'jch-optimize');

        return jch_gen_description($title, $description);
    }

    echo jch_gen_radio_field('css', '1', false, 's1-on s2-on s3-on s4-on s5-on s6-on');
}

function jch_options_javascript_string($title = false)
{
    if ($title ) {
        $description = __('This will combine all javascript files into one file and remove all the links to the individual files from the page, replacing it with a link generated by the plugin to the combined file.',
            'jch-optimize');

        return jch_gen_description($title, $description);
    }

    echo jch_gen_radio_field('javascript', '1', false, 's1-on s2-on s3-on s4-on s5-on s6-on');
}

function jch_options_gzip_string($title = false)
{
    if ($title) {
        $description = __('This setting compresses the generated javascript and CSS combined files with gzip, decreasing file size dramatically. This can decrease file size dramatically.',
            'jch-optimize');

        return jch_gen_description($title, $description);
    }

    echo jch_gen_radio_field('gzip', '0', false, 's1-off s2-on s3-on s4-on s5-on s6-on');
}

function jch_options_css_minify_string($title = false)
{
    if ($title) {
        $description = __('If yes, the plugin will remove all unnecessary whitespaces and comments from the combined CSS file to reduce the total file size.',
            'jch-optimize');

        return jch_gen_description($title, $description);
    }

    echo jch_gen_radio_field('css_minify', '0', false, 's1-off s2-on s3-on s4-on s5-on s6-on');
}

function jch_options_js_minify_string($title = false)
{
    if ($title) {
        $description = __('If yes, the plugin will remove all unnecessary whitespaces and comments from the combined javascript file to reduce the total file size.',
            'jch-optimize');

        return jch_gen_description($title, $description);
    }

    echo jch_gen_radio_field('js_minify', '0', false, 's1-off s2-on s3-on s4-on s5-on s6-on');
}

function jch_options_html_minify_string($title = false)
{
    if ($title ) {
        $description = __('If yes, the plugin will remove all unneccessary whitespaces and comments from HTML to reduce the total size of the web page.',
            'jch-optimize');

        return jch_gen_description($title, $description);
    }

    echo jch_gen_radio_field('html_minify', '0', false, 's1-off s2-on s3-on s4-on s5-on s6-on');
}

function jch_options_defer_js_string($title=false)
{
    if ($title) {
        $description = __('This option will add a <span class="notranslate">\'defer\'</span> attribute to the link of the combined javascript file. This will defer the loading of the javascript until after the page is loaded to reduce \'render-blocking\'.  Do not configure this setting manually to avoid breaking your page.',
            'jch-optimize');

        return jch_gen_description($title, $description);
    }

    echo jch_gen_radio_field('defer_js', '0', false,'s1-off s2-off s3-off s4-off s5-off s6-on');
}


function jch_options_auto_exclude_string()
{
    echo '&nbsp;';
}

function jch_options_includeAllExtensions_string($title = false)
{
    if($title ) {
        $description = __('By default, all files from third party plugins and external domains are excluded. If this setting is enabled, they will be included.', 'jch-optimize');

        return jch_gen_description($title, $description);
    }
    echo jch_gen_radio_field('includeAllExtensions', '0', false, 's1-off s2-off s3-on s4-on s5-on s6-on');
}

function jch_options_auto_advanced_string()
{
    echo '&nbsp;';
}

function jch_options_replaceImports_string($title = false)
{
    if($title ) {
        $description = __('The plugin will replace <span class="notranslate">@import</span> at-rules with the contents of the files they are importing. This will be done recursively.',
            'jch-optimize');

        return jch_gen_description($title, $description);
    }

    echo jch_gen_radio_field('replaceImports', '0', false, 's1-off s2-off s3-off s4-on s5-on s6-on');
}

function jch_options_phpAndExternal_string($title = false)
{
    if($title) {
        $description = __('Javascript and css files with <span class="notranslate">\'.php\'</span> file extensions, and files from external domains will be included in the combined file. This option requires that <span class="notranslate">cURL</span> is installed on your server.', 'jch-optimize');

        return jch_gen_description($title, $description);
    }

    echo jch_gen_radio_field('phpAndExternal', '0', false, 's1-off s2-off s3-off s4-on s5-on s6-on');
}

function jch_options_inlineStyle_string($title = false)
{
    if ($title) {
        $description = __('In-page CSS inside <span class="notranslate">&lt;style&gt;</span> tags will be included in the aggregated file in the order they appear on the page.', 'jch-optimize');

        return jch_gen_description($title, $description);
    }

    echo jch_gen_radio_field('inlineStyle', '0', false, 's1-off s2-off s3-off s4-on s5-on s6-on');
}

function jch_options_inlineScripts_string($title = false)
{
    if($title ){
    $description = __('In-page javascript inside <span class="notranslate">&lt;script&gt;</span> tags will be included in the combined file in the order they appear on the page.',
        'jch-optimize');

    return jch_gen_description($title, $description);
    }

    echo jch_gen_radio_field('inlineScripts', '0', false, 's1-off s2-off s3-off s4-on s5-on s6-on');
}

function jch_options_bottom_js_string($title = false)
{
    if($title) {
        $description = __('Place combined javascript file at bottom of the page just before the ending BODY tag. If some javascript files are excluded while preserving execution order so that the combined javascript file is split around the excluded files, only the last combined javascript file will be placed at the bottom of the page. By default the plugin only combines files found in the HEAD section of the page. This option extends the search to the BODY section.',
            'jch-optimize');

        return jch_gen_description($title, $description);
    }

    echo jch_gen_radio_field('bottom_js', '0', false, 's1-off s2-off s3-off s4-off s5-on s6-on');
}

function jch_options_loadAsynchronous_string($title = false)
{
    if($title) {
        $description = __('The \'asnyc\' attribute is added to the combined javascript file so it will be loaded asynchronously to avoid render blocking and speed up download of the web page. If other files/scripts are excluded while preserving execution order so that the combined file is split around the excluded files, the \'defer\' attribute is instead added to the last combined file following an excluded file/script. This option only works when the combined javascript file is placed at the bottom of the page.',
            'jch-optimize');

        return jch_gen_description($title, $description);
    }

    echo jch_gen_radio_field('loadAsynchronous', '0', false, 's1-off s2-off s3-off s4-off s5-off s6-on');
}
