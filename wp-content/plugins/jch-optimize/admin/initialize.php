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

use JchOptimize\Core\Admin;
use JchOptimize\Core\Helper;
use JchOptimize\Core\Logger;
use JchOptimize\Platform\Cache;
use JchOptimize\Platform\Html;
use JchOptimize\Platform\Plugin;
use JchOptimize\Platform\Settings;

defined('_WP_EXEC') or die('Restricted access');

function check_jch_tasks()
{
	if ( isset( $_GET['jch-task'] ) )
	{
		switch ( $_GET['jch-task'] )
		{
			case 'cleancache':
				delete_jch_cache();
				break;

			case 'browsercaching':
				jch_leverage_browser_cache();
				break;

			case 'filepermissions':
				jch_fix_file_permissions();
				break;

			case 'postresults':
				jch_process_optimize_images_results();
				break;

			case 'orderplugin':
				jch_admin_order_plugin();
				break;
			default:
				break;
		}
	}
}

function jch_get_cache_info()
{
	static $attribute = false;

	if ( $attribute === false )
	{
		try
		{
			$wp_filesystem = Cache::getWpFileSystem();
		}
		catch ( \JchOptimize\Core\Exception $e )
		{
			$wp_filesystem = false;
		}

		if ( $wp_filesystem !== false && $wp_filesystem->exists( JCH_CACHE_DIR ) )
		{
			try
			{
				Cache::initializecache();
			}
			catch ( \JchOptimize\Core\Exception $e )
			{
				return;
			}


			$size    = 0;
			$dirlist = $wp_filesystem->dirlist( JCH_CACHE_DIR );

			foreach ( $dirlist as $file )
			{
				if ( $file['name'] == 'index.html' )
				{
					continue;
				}

				$size += $file['size'];
			}

			$decimals = 2;
			$sz       = 'BKMGTP';
			$factor   = (int) floor( ( strlen( $size ) - 1 ) / 3 );
			$size     = sprintf( "%.{$decimals}f", $size / pow( 1024, $factor ) ) . $sz[$factor];

			$no_files = number_format( count( $dirlist ) - 1 );
		}
		else
		{
			$size     = '0';
			$no_files = '0';
		}

		$attribute = '<div><br><div><em>' . sprintf( __( 'Number of files: <span class="notranslate">%s</span>' ), $no_files ) . '</em></div>'
		             . '<div><em>' . sprintf( __( 'Size: <span class="notranslate">%s</span>' ), $size ) . '</em></div></div>'
		             . '</div>';
	}

	return $attribute;
}

function jch_redirect()
{
	global $jch_redirect;

	if ( $jch_redirect )
	{
		$url = admin_url( 'options-general.php?page=jchoptimize-settings' );

		wp_redirect( $url );
		exit;
	}
}

function jch_get_admin_object()
{
	static $oJchAdmin = null;

	if ( is_null( $oJchAdmin ) )
	{
		global $jch_redirect;

		$params    = Settings::getInstance( get_option( 'jch_options' ) );
		$oJchAdmin = new Admin( $params );

		if ( get_transient( 'jch_optimize_ao_exception' ) )
		{
			delete_transient( 'jch_optimize_ao_exception' );
		}
		else
		{
			try
			{
				$oHtml = new Html( $params );
				$sHtml = $oHtml->getHomePageHtml();
				$oJchAdmin->getAdminLinks( $sHtml, '' );
			}
			catch ( RunTimeException $ex )
			{
				jch_add_notices( 'info', $ex->getMessage() );
				set_transient( 'jch_optimize_ao_exception', 1, 1 );

				$jch_redirect = true;
			}
			catch ( Exception $ex )
			{
				Logger::log( $ex->getMessage(), $params );

				jch_add_notices( 'error', $ex->getMessage() );
				set_transient( 'jch_optimize_ao_exception', 1, 1 );

				$jch_redirect = true;
			}
		}
	}

	return $oJchAdmin;
}

function delete_jch_cache()
{
	global $jch_redirect;

	Helper::clearHiddenValues( Plugin::getPluginParams() );

	try
	{
		$result = Cache::deleteCache();
	}
	catch ( \JchOptimize\Core\Exception $e )
	{
	}

	if ( $result !== false )
	{
		jch_add_notices( 'success', __( 'The plugin\'s cache files were deleted successfully!', 'jch-optimize' ) );
	}
	else
	{
		jch_add_notices( 'error', __( 'An error occurred while trying to delete the plugin\'s cache files!', 'jch-optimize' ) );
	}

	$jch_redirect = true;
}

function jch_add_notices( $type, $text )
{
	$jch_notices = array();

	if ( $notices = get_transient( 'jch_notices' ) )
	{
		$jch_notices = $notices;
	}

	$jch_notices[$type][] = $text;

	set_transient( 'jch_notices', $jch_notices, 60 * 5 );
}

function jch_send_notices()
{
	$jch_notices = get_transient( 'jch_notices' );

	foreach ( $jch_notices as $type => $notices )
	{
		$notices = array_unique( $notices );
		?>
		<div class="notice notice-<?php echo $type ?>">
			<?php

			foreach ( $notices as $notice )
			{

				?>
				<p> <?php echo $notice ?></p>
				<?php

			}

			?>
		</div>
		<?php

	}

	delete_transient( 'jch_notices' );
}

function jch_fix_file_permissions()
{
	global $jch_redirect;

	try
	{
		$wp_filesystem = Cache::getWpFileSystem();
	}
	catch ( \JchOptimize\Core\Exception $e )
	{
		$wp_filesystem = false;
	}

	if ( $wp_filesystem === false )
	{
		$result = false;
	}
	else
	{
		$result = true;

		try
		{
			jch_chmod( JCH_PLUGIN_DIR, $wp_filesystem );
		}
		catch ( Exception $ex )
		{
			$result = false;
		}
	}

	if ( $result )
	{
		jch_add_notices( 'success', __( 'The permissions of all the files and folders in the plugin were successfully updated.', 'jch-optimize' ) );
	}
	else
	{
		jch_add_notices( 'error', __( 'The plugin failed to update the permissions of the files and folders in the plugin.', 'jch-optimize' ) );
	}

	$jch_redirect = true;
}

function jch_chmod( $file, $wp_fs )
{

	/** @var \WP_Filesystem_Base $wp_fs */
	if ( $wp_fs->is_file( $file ) )
	{
		$mode = FS_CHMOD_FILE;
	}
	elseif ( $wp_fs->is_dir( $file ) )
	{
		$mode = FS_CHMOD_DIR;
	}
	else
	{
		throw new Exception;
	}

	if ( ! ( @chmod( $file, $mode ) ) )
	{
		throw new Exception;
	}

	if ( $wp_fs->is_dir( $file ) )
	{
		$file     = trailingslashit( $file );
		$filelist = $wp_fs->dirlist( $file );

		foreach ( (array) $filelist as $filename => $filemeta )
		{
			jch_chmod( $file . $filename, $wp_fs );
		}
	}
}

function jch_process_optimize_images_results()
{
	global $jch_redirect;

	if ( file_exists( JCH_PLUGIN_DIR . 'status.json' ) )
	{
		unlink( JCH_PLUGIN_DIR . 'status.json' );
	}

	$cnt    = filter_input( INPUT_GET, 'cnt', FILTER_SANITIZE_NUMBER_INT );
	$dir    = filter_input( INPUT_GET, 'dir', FILTER_SANITIZE_STRING );
	$status = filter_input( INPUT_GET, 'status', FILTER_SANITIZE_STRING );
	$msg    = filter_input( INPUT_GET, 'msg', FILTER_DEFAULT );

	//$dir = Utility::decrypt($dir);

	if ( $cnt !== false && ! is_null( $cnt ) )
	{
		jch_add_notices( 'success', sprintf( __( '<span class="notranslate">%1$d</span> images were optimized in <span class="notranslate">%2$s</span>', 'jch-optimize' ), $cnt, $dir ) );
	}
	elseif ( $status !== false && ! is_null( $status ) )
	{
		jch_add_notices( 'error', sprintf( __( 'Failed to optimize image: <span class="notranslate">%1$s</span>', 'jch-optimize' ), $msg ) );
	}

	$jch_redirect = true;
}

function jch_admin_order_plugin()
{
    global $jch_redirect;

    if ( jch_order_plugin() )
    {
        jch_add_notices( 'success', __( 'The plugins\' order was sucessfully updated!', 'jch-optimize' ) );
    }
    else
    {
        jch_add_notices( 'error', __( 'An unknown error occurred while trying to update the plugins\' order!', 'jch-optimize' ) );
    }
    $jch_redirect = true;
}


function jch_leverage_browser_cache()
{
    global $jch_redirect;

    $expires = Admin::leverageBrowserCaching();

    if ( $expires === false )
    {
        jch_add_notices( 'error', __( 'The plugin failed to add the \'leverage browser cache\' codes to the .htaccess file.', 'jch-optimize' ) );
    }
    elseif ( $expires == 'FILEDOESNTEXIST' )
    {
        jch_add_notices( 'warning', __( 'An .htaccess file could not be found in the root folder of the site.', 'jch-optimize' ) );
    }
    elseif ( $expires == 'CODEALREADYINFILE' )
    {
        jch_add_notices( 'notice', __( 'Codes for \'leverage browser caching\' already exists in the .htaccess file.', 'jch-optimize' ) );
    }
    else
    {
        jch_add_notices( 'success', __( 'Codes for \'leverage browser caching\' were added to the .htaccess file successfully.', 'jch-optimize' ) );
    }

    $jch_redirect = true;
}