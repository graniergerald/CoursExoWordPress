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

### Exclude urls ###

function jch_url_exclude_section_text()
{
	jch_group_end();

	echo '</div>
  <div class="tab-pane" id="exclude">';

	$header      = __( 'Exclude urls from the plugin', 'jch-optimize' );
	$description = __( 'Enter any part of a url to exclude that page from optimization. You will need to add these urls to the list manually by typing the url in the textbox and click the \'Add item\' button.',
		'jch-optimize' );

	jch_group_start( $header, $description );
}

function jch_options_url_exclude_string($title = false)
{
    if ($title) {
        $description = __('Enter urls to exclude', 'jch-optimize');

        return jch_gen_description($title, $description);
    }

	$option      = 'url_exclude';
	$values = jch_get_field_value( 'url', $option, 'file' );

	echo jch_gen_multiselect_field( $option, $values, false);
}

### Exclude preserving execution order ###

function jch_exclude_peo_section_text()
{
	jch_group_end();

	$header      = __( 'Exclude files while preserving the original execution order of codes on the page', 'jch-optimize' );
	$description = __( 'These settings are used to exclude individual files, or files from select plugins, while maintaining the original execution order of codes on the page to ensure the page doesn\'t break. The combined file will split itself around the excluded files to preserve the order and ensure that no dependencies on any other combined files/scripts are broken. If you\'re not seeing the files or extensions you want to exclude in the drop-down list, manually add the files or extensions to the list. To add a file to the list manually, type the url in the textbox and click the \'Add item\' button.',
		'jch-optimize' );

	jch_group_start( $header, $description );
}

function jch_options_excludeCss_string($title = false)
{
    if ($title) {
        $description = __('Select the CSS files you want to exclude.', 'jch-optimize');

        return jch_gen_description($title, $description);
    }

	$option      = 'excludeCss';
	$values = jch_get_field_value( 'css', $option, 'file' );

	echo jch_gen_multiselect_field( $option, $values, false );
}

function jch_options_excludeJs_peo_string($title = false)
{
    if ($title) {
        $description = __('Select the javascript files you want to exclude.', 'jch-optimize');

        return jch_gen_description($title, $description);
    }

	$option      = 'excludeJs_peo';
	$values = jch_get_field_value( 'js', $option, 'file' );

	echo jch_gen_multiselect_field( $option, $values, false );
}

function jch_options_excludeCssComponents_string($title = false)
{
    if($title) {
        $description = __('Select the plugins that you want to exclude CSS files from.', 'jch-optimize');

        return jch_gen_description($title, $description);

    }

	$option      = 'excludeCssComponents';
	$values = jch_get_field_value( 'css', $option, 'extension' );

	echo jch_gen_multiselect_field( $option, $values, false );
}

function jch_options_excludeJsComponents_peo_string($title = false)
{
    if ($title) {
        $description = __('Select the plugins that you want to exclude javascript files from.',
            'jch-optimize');

        return jch_gen_description($title, $description);
    }

	$option      = 'excludeJsComponents_peo';
	$values = jch_get_field_value( 'js', $option, 'extension' );

	echo jch_gen_multiselect_field( $option, $values, false );
}

function jch_options_excludeStyles_string($title = false)
{
    if ($title) {
        $description = __('Select the \'in-page\' <span class="notranslate">&lt;style&gt;</span> you want to exclude.',
            'jch-optimize');

        return jch_gen_description($title, $description);
    }

	$option = 'excludeStyles';
	$values = jch_get_field_value( 'css', $option, 'style' );

	echo jch_gen_multiselect_field( $option, $values, false);
}

function jch_options_excludeScripts_peo_string($title = false)
{
    if ($title) {
        $description = __('Select the \'in-page\' <span class="notranslate">&lt;script&gt;</span> you want to exclude.',
            'jch-optimize');

        return jch_gen_description($title, $description);
    }

	$option = 'excludeScripts_peo';
	$values = jch_get_field_value( 'js', $option, 'script' );

	echo jch_gen_multiselect_field( $option, $values, false );
}

function jch_options_excludeAllStyles_string($title =false)
{
    if($title) {
        $description = __('This is useful if you are generating an excess amount of cache files due to the file name of the combined CSS file keeps changing and you can\'t identify which STYLE declaration is responsible',
            'jch-optimize');

        return jch_gen_description($title, $description);
    }

	echo jch_gen_radio_field( 'excludeAllStyles', '0', false );
}

function jch_options_excludeAllScripts_string($title=false)
{
    if($title) {
        $description = __('This is useful if you are generating an excess amount of cache files due to the file name of the combined javascript file keeps changing and you can\'t identify which SCRIPT declaration is responsible',
            'jch-optimize');

        return jch_gen_description($title, $description);
    }

	echo jch_gen_radio_field( 'excludeAllScripts', '0', false);

}

### Exclude ignoring execution order ###

function jch_exclude_ieo_section_text()
{
	jch_group_end();

	$header      = __( 'Exclude files without maintaining the original execution order of files on the page', 'jch-optimize' );
	$description = __( 'Only use these settings if you\'re sure that the files/scripts you are excluding does not have any dependencies on any other files/scripts that are combined. If you are not sure then use the above section to exclude your files to avoid breaking your page.',
		'jch-optimize' );

	jch_group_start( $header, $description );
}

function jch_options_excludeJs_string($title = false)
{
    if ($title) {
        $description = __('Select the javascript files you want to exclude.', 'jch-optimize');

        return jch_gen_description($title, $description);
    }

	$option      = 'excludeJs';
	$values = jch_get_field_value( 'js', $option, 'file' );

	echo jch_gen_multiselect_field( $option, $values, false);
}

function jch_options_excludeJsComponents_string($title =false)
{
    if ($title) {
        $description = __('Select the plugins that you want to exclude javascript files from.',
            'jch-optimize');

        return jch_gen_description($title, $description);
    }

	$option      = 'excludeJsComponents';
	$values = jch_get_field_value( 'js', $option, 'extension' );

	echo jch_gen_multiselect_field( $option, $values, false );
}

function jch_options_excludeScripts_string($title = false)
{
    if($title) {
        $description = __('Select the \'in-page\' <span class="notranslate">&lt;script&gt;</span> you want to exclude.',
            'jch-optimize');

        return jch_gen_description($title, $description);
    }

	$option = 'excludeScripts';
	$values = jch_get_field_value( 'js', $option, 'script' );

	echo jch_gen_multiselect_field( $option, $values, false);

}

### Don't move files section ###

function jch_dontmove_section_text()
{
	jch_group_end();

	$header      = __( 'Don\'t move these files to the bottom of the page' );
	$description = __( 'The plugin will move all excluded and combined javascript files to the bottom of the page when using the Premium or Optimum setting. If there\'s a javascript file or script that is excluded that you DON\'T want moved to the bottom of the page, enter them here in these settings. These files/scripts must be excluded above for these settings to take effect.' );

	jch_group_start( $header, $description );
}

function jch_options_dontmoveJs_string($title=false)
{
    if($title) {
        $description = __('Don\'t move these javascript files that were excluded above to the bottom of the page. These files will be left at their original position on the page.');

        return jch_gen_description($title, $description);
    }

	$option      = 'dontmoveJs';
	$values = jch_get_field_value( 'js', $option, 'file' );

	echo jch_gen_multiselect_field( $option, $values, false);
}

function jch_options_dontmoveScripts_string($title = false)
{
    if($title) {
        $description = __('Enter any substring of an excluded script here to prevent this script being moved to the bottom. Inline scripts in the BODY of the document containing the \'document.write\' method will NOT be moved by default.');

        return jch_gen_description($title, $description);
    }

	$option      = 'dontmoveScripts';
	$values = jch_get_field_value( 'js', $option, 'script' );

	echo jch_gen_multiselect_field( $option, $values, false );
}

