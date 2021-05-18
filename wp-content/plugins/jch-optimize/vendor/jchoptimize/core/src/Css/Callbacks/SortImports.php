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


class SortImports extends CallbackBase
{
	protected $sAtImports = '';

	function processMatches( $aMatches )
	{
		if ($this->sContext == 'charset')
		{
			return '';
		}

		if ($this->sContext == 'import')
		{
			$this->appendAtImports($aMatches[0]);

			return '';
		}
	}

	protected function appendAtImports( $sAtImport )
	{
		$this->sAtImports .= $sAtImport;
	}

	public function getAtImports()
	{
		return $this->sAtImports;
	}
}
