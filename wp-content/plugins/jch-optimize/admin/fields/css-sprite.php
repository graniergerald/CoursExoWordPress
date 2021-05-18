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

### CSS Sprite Section ###

function jch_sprite_manual_section_text()
{
	jch_group_end();

	echo '</div>
  <div class="tab-pane" id="sprite">';

	$header      = __( 'Sprite Generator', 'jch-optimize' );
	$description = __( 'If yes will combine selected background images in one image called a sprite to reduce http requests.',
		'jch-optimize' );

	jch_group_start( $header, $description );
}

function jch_options_csg_enable_string()
{
	$description = '';

	echo jch_gen_radio_field( 'csg_enable', '0', $description );
}

function jch_options_csg_direction_string($title=false)
{
    if($title) {
        $description = __('Determine in which direction the images must be placed in the sprite.', 'jch-optimize');

        return jch_gen_description($title, $description);
    }

	$values = array(
		'vertical'   => __( 'vertical', 'jch-optimize' ),
		'horizontal' => __( 'horizontal', 'jch-optimize' )
	);

	echo jch_gen_select_field( 'csg_direction', 'vertical', $values, false);
}

function jch_options_csg_wrap_images_string($title=false)
{
    if($title) {
        $description = __('This setting will wrap images in sprite into another row or column if the length of the sprite becomes longer than 2000px.',
            'jch-optimize');

        return jch_gen_description($title, $description);
    }

	echo jch_gen_radio_field( 'csg_wrap_images', '0', false);
}

function jch_options_csg_exclude_images_string($title=false)
{
    if($title) {
        $description = __('You can exclude one or more of the images if they are displayed incorrectly.',
            'jch-optimize');

        return jch_gen_description($title, $description);
    }

	$option = 'csg_exclude_images';

	$values = jch_get_field_value( 'images', $option );

	echo jch_gen_multiselect_field( $option, $values, false );
}

function jch_options_csg_include_images_string($title=false)
{
    if($title) {
        $description = __('You can include additional images in the sprite to the ones that were selected by default. Exercise care with this option as these files are likely to not display correctly.',
            'jch-optimize');

        return jch_gen_description($title, $description);
    }

	$option = 'csg_include_images';
	$values = jch_get_field_value( 'images', $option );

	echo jch_gen_multiselect_field( $option, $values, false);

}
