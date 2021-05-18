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

function jch_images_section_text()
{
    jch_group_end();

	echo '</div>
  <div class="tab-pane" id="images">';

	$header      = __( 'Optimize Images', 'jch-optimize' );
	$description = __( 'Use our API to optimize the images on your server. Be sure to save your \'Download ID\' in the plugin before trying to optimize images as that will authenticate you to access the API. Use the file tree to select the subfolders and files you want to optimize. Files will be optimized in subfolders recursively. If you want to rescale your images while optimizing, enter the new width and height. Original images will be saved in the /wp-content/jch_optimize_backup_images/ directory.',
		'jch-optimize' );

	jch_group_start( $header, $description );
}

//function jch_options_kraken_optimization_level_string()
//{
//        $description = __('You can sacrifice a small amount of image quality for up to 90% of the original file weight by choosing lossy optimization versus Non-lossy. (Recommended!)',
//                          'jch-optimize');
//
//        $values = array('0' => __('Non-Lossy', 'jch-optimize'), '1' => __('Lossy', 'jch-optimize'));
//
//        echo jch_gen_select_field('kraken_optimization_level', '0', $values, $description);
//        ;
//}

function jch_options_ignore_optimized_string($title=false)
{
    if($title) {
        $description = __('Will not attempt to optimize any images in subfolders that have already been marked as optimized.',
            'jch-optimize');

        return jch_gen_description($title, $description);
    }

	echo jch_gen_radio_field( 'ignore_optimized', '1', false );
}

function jch_images_foldertree_section_text()
{
	jch_group_end();
}

function jch_options_optimize_images_string()
{
	

	
      echo jch_gen_proonly_field();
      

}
