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

function jch_load_resource_files( $hook )
{
	if ( 'settings_page_jchoptimize-settings' != $hook )
	{
		return;
	}

	wp_enqueue_style( 'jch-bootstrap-css' );
	wp_enqueue_style( 'jch-admin-css' );
	wp_enqueue_style( 'jch-fonts-css' );
	wp_enqueue_style( 'jch-chosen-css' );
	wp_enqueue_style( 'jch-wordpress-css' );

	wp_enqueue_script( 'jch-wordpress-js' );
	wp_enqueue_script( 'jch-bootstrap-js' );
	wp_enqueue_script( 'jch-tabsstate-js' );
	wp_enqueue_script( 'jch-adminutility-js' );
	wp_enqueue_script( 'jch-chosen-js' );
	wp_enqueue_script( 'jch-collapsible-js' );

	


}

function jch_load_scripts()
{

	?>
	<style type="text/css">
            .chosen-container-multi .chosen-choices li.search-field input[type=text] {
                height: 25px;
            }

            .chosen-container {
                margin-right: 4px;
            }

	</style>
	<script type="text/javascript">
            function submitJchSettings() {
                jQuery("form.jch-settings-form").submit();
            }

            jQuery(document).ready(function () {
                jQuery(".chzn-custom-value").chosen({width: "240px"});

                jQuery('.collapsible').collapsible();
            });

	    <?php                                  ?>

	</script>
	<?php

}