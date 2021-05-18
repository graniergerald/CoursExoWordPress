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
namespace JchOptimize\Platform;

defined('_WP_EXEC') or die('Restricted access');

use JchOptimize\Core\FileRetriever;
use JchOptimize\Core\Logger;
use JchOptimize\Core\Exception;
use JchOptimize\Core\Interfaces\Html as HtmlInterface;

class Html implements HtmlInterface
{
        protected $params;
        
        public function __construct($params)
        {
                $this->params = $params;
        }
        
        public function getHomePageHtml()
        {
                JCH_DEBUG ? Profiler::mark('beforeGetHtml') : null;
                
                $url = home_url() . '/?jchbackend=1';
                
                try
                {
                        $oFileRetriever = FileRetriever::getInstance();

                        $response = $oFileRetriever->getFileContents($url);

                        if ($oFileRetriever->response_code != 200)
                        {
                                throw new Exception(
                                Utility::translate('Failed fetching front end HTML with response code ' . $oFileRetriever->response_code)
                                );
                        }

                        JCH_DEBUG ? Profiler::mark('afterGetHtml') : null;

                        return $response;
                }
                catch (Exception $e)
                {
                        Logger::log($url . ': ' . $e->getMessage(), $this->params);

                        JCH_DEBUG ? Profiler::mark('afterGetHtml)') : null;

                        throw new \RunTimeException(_('Load or refresh the front-end site first then refresh this page '
                                . 'to populate the multi select exclude lists.'));
                }
        }

	public function getMainMenuItemsHtmls()
	{
		// TODO: Implement getMainMenuItemsHtmls() method.
	}
}

