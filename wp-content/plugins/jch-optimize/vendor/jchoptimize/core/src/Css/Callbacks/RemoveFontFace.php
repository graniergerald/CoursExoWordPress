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


class RemoveFontFace extends CallbackBase
{
	protected $sFontFace = '';

	function processMatches( $aMatches )
	{
		if (!preg_match('#font-display#i', $aMatches[0]))
		{
			$aMatches[0] = rtrim(substr($aMatches[0], 0, -1), ';') . ';font-display:swap}';
		}

		$this->sFontFace .= $aMatches[0];

		return '';
	}

	public function getFontFace()
	{
		return $this->sFontFace;
	}
}