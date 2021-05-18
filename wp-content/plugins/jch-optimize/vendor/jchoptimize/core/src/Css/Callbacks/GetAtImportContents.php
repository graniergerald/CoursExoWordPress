<?php

/**
 * JCH Optimize - Performs several front-end optimizations for fast downloads
 *
 * @package   jchoptimize/core
 * @author    Samuel Marshall <samuel@jch-optimize.net>
 * @copyright Copyright (c) 2020 Samuel Marshall / JCH Optimize
 * @license   GNU/GPLv3, or later. See LICENSE file
 *
 * If LICENSE file missing, see <http://www.gnu.org/licenses/>.
 */

namespace JchOptimize\Core\Css\Callbacks;

defined( '_JCH_EXEC' ) or die( 'Restricted access' );


use JchOptimize\Core\Combiner;
use JchOptimize\Core\Html\Processor;
use JchOptimize\Core\Url;
use JchOptimize\Platform\Cache;


class GetAtImportContents extends CallbackBase
{
	/** @var  Processor $oHtmlProcessor */
	protected $oHtmlProcessor;

	function processMatches( $aMatches )
	{
		$sUrl   = $aMatches[3];
		$sMedia = $aMatches[4];

		if ( empty( $sUrl )
		     || ! $this->oHtmlProcessor->isHttpAdapterAvailable( $sUrl )
		     || ( Url::isSSL( $sUrl ) && ! extension_loaded( 'openssl' ) )
		     || ( ! Url::isHttpScheme( $sUrl ) )
		)
		{
			return $aMatches[0];
		}

		if ( $this->oHtmlProcessor->isDuplicated( $sUrl ) )
		{
			return '';
		}

		//Need to handle file specially if it imports google font
		if ( strpos( $sUrl, 'fonts.googleapis.com' ) !== false )
		{
			//Get array of files from cache that imports Google font files
			$aContainsGF = Cache::getCache( 'jch_hidden_containsgf' );

			//If not cache found initialize to empty array
			if ( $aContainsGF === false )
			{
				$aContainsGF = array();
			}

			//If not in array, add to array
			if ( isset( $this->aUrl['url'] ) && ! in_array( $this->aUrl['url'], $aContainsGF ) )
			{
				$aContainsGF[] = $this->aUrl['url'];

				//Store array of filenames that imports google font files to cache
				Cache::saveCache( $aContainsGF, 'jch_hidden_containsgf' );
			}
		}

		$aUrlArray = array();

		$aUrlArray[0]['url']   = $sUrl;
		$aUrlArray[0]['media'] = $sMedia;
		//$aUrlArray[0]['id']    = md5($aUrlArray[0]['url'] . $this->oHtmlProcessor->sFileHash);

		$oCombiner     = new Combiner( $this->oParams, $this->oHtmlProcessor );
		$oCssProcessor = new \JchOptimize\Core\Css\Processor($this->oParams);
		$sFileContents = $oCombiner->combineFiles( $aUrlArray, 'css' , $oCssProcessor);

		if ( $sFileContents === false )
		{
			return $aMatches[0];
		}

		return $sFileContents;
	}

	public function setHtmlProcessor( $oHtmlProcessor )
	{
		$this->oHtmlProcessor = $oHtmlProcessor;
	}
}
