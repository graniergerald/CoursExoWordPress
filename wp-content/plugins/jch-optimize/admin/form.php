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

function jch_options_form()
{
	?>

    <div>
        <h2>JCH Optimize Settings</h2>
        <form action="options.php" method="post" class="jch-settings-form">
            <div style="width: 90%;">
                <input name="Submit" type="submit" class="button button-primary"
                       value="<?php esc_attr_e( 'Save Changes', 'jch-optimize' ); ?>"/>
		    <?php
            $subscribe_url = 'https://www.jch-optimize.net/subscribe/levels.html/#wordpress';
		    

						   				?>
										<a class="right button button-secondary" href="<?php echo $subscribe_url; ?>" target="_blank"><?php _e('Upgrade to Pro', 'jch-optimize'); ?></a>

										<?php
										

		    ?>

            </div>
            <!-- Nav tabs -->
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#description" data-toggle="tab">
			    <?php _e( 'Description', 'jch-optimize' ) ?>
                    </a>
                </li>

		    <?php

		    if ( version_compare( PHP_VERSION, '5.3.0', '>=' ) )
		    {

			    ?>

                        <li>
                            <a href="#combine-css-js" data-toggle="tab">
				    <?php _e( 'Combine CSS/JS', 'jch-optimize' ) ?>
                            </a>
                        </li>
                        <li>
                            <a href="#exclude" data-toggle="tab">
				    <?php _e( 'Exclude Options', 'jch-optimize' ) ?>
                            </a>
                        </li>
                        <li>
                            <a href="#misc" data-toggle="tab">
				    <?php _e( 'Miscellaneous', 'jch-optimize' ) ?>
                            </a>
                        </li>
                        <li>
                            <a href="#page-cache" data-toggle="tab">
				    <?php _e( 'Page Cache', 'jch-optimize' ) ?>
                            </a>
                        </li>
                        <li>
                            <a href="#optimize-css" data-toggle="tab">
				    <?php _e( 'Optimize CSS <span class="label label-important" style="line-height: 12px;">New!</span>', 'jch-optimize' ) ?>
                            </a>
                        </li>
                        <li>
                            <a href="#sprite" data-toggle="tab">
				    <?php _e( 'CSS Sprite', 'jch-optimize' ) ?>
                            </a>
                        </li>
                        <li>
                            <a href="#http2" data-toggle="tab">
				    <?php _e( 'Http/2 Push <span class="label label-important" style="line-height: 12px;">New!</span>' , 'jch-optimize' ) ?>
                            </a>
                        </li>
                        <li>
                            <a href="#lazyload" data-toggle="tab">
				    <?php _e( 'Lazy-Load', 'jch-optimize' ) ?>
                            </a>
                        </li>
                        <li>
                            <a href="#cdn" data-toggle="tab">
				    <?php _e( 'CDN <span class="label label-important" style="line-height: 12px;">New!</span>', 'jch-optimize' ) ?>
                            </a>
                        </li>
                        <li>
                            <a href="#images" data-toggle="tab">
				    <?php _e( 'Optimize Images', 'jch-optimize' ) ?>
                            </a>
                        </li>
			    <?php

		    }

		    ?>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">

                <div class="tab-pane active" id="description">
                    <div id="extension-container" style="text-align:left;">
                        <h1>JCH Optimize Plugin</h1>
                        <h3>(Version 2.8.1)</h3>
                        <p><?php _e( 'This plugin speeds up your website by performing a number of front end optimizations to your website automatically. These optimizations reduce both your webpage size and the number of http requests required to download your webpages and results in reduced server load, lower bandwidth requirements, and faster page loading times.', 'jch-optimize' ) ?></p>
                        <p><img src="<?php echo JCH_PLUGIN_URL ?>/logo.png"
                                style="float: none"/></p>
                        <h2><?php _e( 'Major Features', 'jch-optimize' ) ?></h2>
                        <ul>
                            <li><?php _e( 'Combine and gzip CSS and javascript files', 'jch-optimize' ) ?></li>
                            <li><?php _e( 'Minify combined files and HTML', 'jch-optimize' ) ?></li>
                            <li><?php _e( 'Combine select background images into a sprite', 'jch-optimize' ) ?></li>
                            <li><?php _e( 'Page cache', 'jch-optimize' ) ?></li>
                            <li><?php _e( 'CDN support', 'jch-optimize' ) ?></li>
                            <li><?php _e( 'Lazy-load images', 'jch-optimize' ) ?></li>
                            <li><?php _e( 'Optimize CSS Delivery', 'jch-optimize' ) ?></li>
                        </ul>
                        <h2><?php _e( 'Instructions', 'jch-optimize' ) ?></h2>
                        <p><?php _e( 'First deactivate all page caching features and plugins, then use the \'Automatic Settings\' <span class="notranslate">(Minimum - Optimum)</span> to configure the plugin. The \'Automatic Settings\' are concerned with the combining of the CSS and javascript files, and the management of the combined files, and automatically sets the options in the \'Automatic Settings Groups\'. Use the Exclude options to exclude files or plugins that don\'t work so well with JCH Optimize. You can then try the other optimization features in turn to further configure the plugin and optimize your site. Flush all your cache before re-enabling caching plugins.', 'jch-optimize' ) ?></p>
                        <h2><?php _e( 'Support', 'jch-optimize' ) ?></h2>
                        <p><?php printf( wp_kses( __( 'First check out the <a href="%1$s" target="_blank">documentation</a>, particularly the <a href="%2$s" target="_blank">Getting Started</a> and <a href="%3$s" target="_blank">How to optimize your site</a> pages on the plugin\'s website to learn how to use and configure the plugin.', 'jch-optimize' ), array(
					'a' => array(
						'href'   => array(),
						'target' => array()
					)
				) ), esc_url( 'https://www.jch-optimize.net/documentation.html' ), esc_url( 'https://www.jch-optimize.net/documentation/getting-started.html' ), esc_url( 'https://www.jch-optimize.net/documentation/optimizing-your-site.html' ) ); ?></p>
                        <p><?php printf( wp_kses( __( 'Read <a href="%s" target="_blank">Here</a> for some troubleshooting guides to resolve some common issues users generally encounter with using the plugin.', 'jch-optimize' ), array(
					'a' => array(
						'href'   => array(),
						'target' => array()
					)
				) ), esc_url( 'https://www.jch-optimize.net/documentation/troubleshooting.html' ) ); ?></p>
                        <p><?php printf( wp_kses( __( 'You\'ll need a subscription to submit tickets to get premium support in configuring the plugin to resolve conflicts so <a href="%1$s" target="_blank">subscribe</a> to <em>JCH Optimize for WordPress</em> and access your account to submit a ticket. Otherwise you can use the <a href="%2$s" target="_blank" >WordPress support system</a> to submit support requests.', 'jch-optimize' ), array(
					'a'  => array(
						'href'   => array(),
						'target' => array()
					),
					'em' => array()
				) ), esc_url( $subscribe_url ), esc_url( 'https://wordpress.org/support/plugin/jch-optimize/' ) ); ?></p>
                        <p class="notice notice-info"
                           style="margin: 1em 0; padding: 10px 12px"><?php printf( wp_kses( __( 'If you use this plugin please consider posting a review on the plugin\'s <a href="%s" target="_blank" >WordPress page</a>. If you\'re having problems, please submit for support and give us a chance to resolve your issues before reviewing. Thanks.', 'jch-optimize' ), array(
					'a' => array(
						'href'   => array(),
						'target' => array()
					)
				) ), esc_url( 'https://wordpress.org/support/plugin/jch-optimize/reviews/' ) ); ?></p>

                    </div>
                </div>

			<?php do_settings_sections( 'jch-sections' ); ?>
                </div>

		    <?php settings_fields( 'jch_options' ); ?>
		    <?php

		    $options = get_option( 'jch_options' );

		    ?>
                <input type="hidden" id="jch_options_hidden_containsgf" name="jch_options[hidden_containsgf]"
                       value="<?php echo ! empty( $options['hidden_containsgf'] ) ? $options['hidden_containsgf'] : ''; ?>">
                <input type="hidden" id="jch_options_hidden_api_secret" name="jch_options[hidden_api_secret]"
                       value="11e603aa">
                <input name="Submit" class="button button-primary" type="submit"
                       value="<?php esc_attr_e( 'Save Changes', 'jch-optimize' ); ?>"/>
        </form>
    </div>
	<?php
}
