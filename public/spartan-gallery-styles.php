<?php
/**
 * Spartan Gallery Plugin plugin style functions
 *
 * @category  WordPress_Spartan_Gallery_Plugin
 * @package   Spartan_Gallery
 * @author    Freelancer Martin
 * @license   GPL-2.0+
 * @link      https://themes.developerforwebsites.com
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

/**
* Image styles
*
* @since Spartan Gallery 1.0.2
*
* @param array  $urls           URLs to print for resource hints.
* @param string $relation_type  The relation type the URLs are printed.
* @return array $urls           URLs to print for resource hints.
*/
Class Spartan_Gallery_Generated_CSS_Output
{


      static function output_php_Css( $attachments  )
      {

					$image_options = get_post_meta( $attachments[0]->post_parent , 'spartan-gallery-meta', true ); // array
					//print_r( $image_options );
					$css = '';
					$css .= '<style>';
						$css .= '.image
											{
												border: '.$image_options['border_width'].'px '.$image_options['border_style'].'  '.$image_options['border_color'].';
											}';
						if ( $image_options['container_settings_on_off']  == 'on' ) {
							$css .= '.spartan-gallery-wrapper
												{
													border: '.$image_options['container_border_range'].'px '.$image_options['container_border_style'].'  '.$image_options['container_border_color'].';
													background-color: '.$image_options['container_background_color'].';
													height: '.$image_options['container_height_range'].''.$image_options['gallery_container_measure_value'].';
													width: '.$image_options['container_width_range'].''.$image_options['gallery_container_measure_value'].';
												}';
						}
						if ( $image_options['display_text'] == 'on' ) {
								$css .= '.spartan-gallery-img-description,
												 .spartan-gallery-img-button,
													{
														text-transform: '.$image_options['font_transform'].'px ;
														letter-spacing: '.$image_options['letter_spacing'].'px;
														line-height: '.$image_options['line_height'].';
														line-spacing: '.$image_options['container_width_range'].''.$image_options['gallery_container_measure_value'].';
														font-style: '.$image_options['font_style'].';
														font-size: '.$image_options['container_font_size'].';
														font-weight: '.$image_options['font_weight'].';
														text-decoration: '.$image_options['container_border_range'].'px '.$image_options['container_border_style'].'  '.$image_options['container_border_color'].';
													}';

						}
						if ( isset( $image_options['add_extra_css'] ) ) {
							$css .= $image_options['add_extra_css'];
						}

					$css .= '</style>';

					print $css;

			}


}
