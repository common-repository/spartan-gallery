<?php
/**
 * Spartan Gallery Plugin popup screen
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
* Image gallerry button
*
* @since Spartan Gallery 1.0.2
*
* @param array  $urls           URLs to print for resource hints.
* @param string $relation_type  The relation type the URLs are printed.
* @return array $urls           URLs to print for resource hints.
*/

function button_url_get_meta( $value ) {
	global $post;

	$field = get_post_meta( $post->ID, $value, true );
	if ( ! empty( $field ) ) {
		return is_array( $field ) ? stripslashes_deep( $field ) : stripslashes( wp_kses_decode_entities( $field ) );
	} else {
		return false;
	}
}


/**
* Image gallerry button
*
* @since Spartan Gallery 1.0.2
*
* @param array  $urls           URLs to print for resource hints.
* @param string $relation_type  The relation type the URLs are printed.
* @return array $urls           URLs to print for resource hints.
*/

function button_url_add_meta_box() {
	add_meta_box(
		'button_url-button-url',
		__( 'b', 'button_url' ),
		'button_url_html',
		'spartan_gallery_type',
		'normal',
		'low'
	);
}
add_action( 'add_meta_boxes', 'button_url_add_meta_box' );



/**
* Image gallerry button
*
* @since Spartan Gallery 1.0.2
*
* @param array  $urls           URLs to print for resource hints.
* @param string $relation_type  The relation type the URLs are printed.
* @return array $urls           URLs to print for resource hints.
*/
function button_url_html( $post) {
	wp_nonce_field( '_button_url_nonce', 'button_url_nonce' );


	$args = array(
		'post_type'   => 'attachment',
		'numberposts' => -1,
		//'post_parent' => $page_id,
		'post_status' => null,
		'meta_query'  => array(
			array(
				'key'     => 'spartan_gallery',
				'compare' => '=',
			)
		)

	);

	$attachments = get_posts( $args );


  foreach ( (array) $attachments as $attachment_id => $attachment_value ) {
	$field = get_post_meta( $attachment_value->ID, 'button_url_buttontitle'.$attachment_value->ID, true );
	print_r( $field );
  echo '<div class="popup" data-popup="popup-'.$attachment_value->ID.'">';
  echo '<div class="popup-inner">';
        echo '<p>';
        echo  '<a><label for="button_url_buttonurl'.$attachment_value->ID.'">'._e( "Insert Button Url   ", "button_url" ).'   </label></a>';
        echo  '<a><input maxlength="160" type="text" name="button_url_buttonurl'.$attachment_value->ID.'" id="button_url_buttonurl'.$attachment_value->ID.'" value="'.button_url_get_meta( "button_url_buttonurl" .$attachment_value->ID ).'"></a>';
        echo '  </p>';

        echo '<p>';
        echo  '<a><label for="button_url_buttonurl'.$attachment_value->ID.'">'._e( "Insert Button Title   ", "button_url" ).'   </label></a>';
        echo  '<a><input maxlength="160" type="text" name="button_url_buttontitle'.$attachment_value->ID.'" id="button_url_buttontitle'.$attachment_value->ID.'" value="'.button_url_get_meta( "button_url_buttontitle" .$attachment_value->ID ).'"></a>';
        echo '  </p>';

        echo '<p>';
        echo  '<a><label for="imgtitle'.$attachment_value->ID.'">'._e( "Insert Image Title   ", "button_url" ).'   </label></a>';
        echo  '<a><input maxlength="160" type="text" name="imgtitle'.$attachment_value->ID.'" id="imgtitle'.$attachment_value->ID.'" value="'.button_url_get_meta( "imgtitle" .$attachment_value->ID ).'"></a>';
        echo '  </p>';
        echo '<p>';

        echo  '<a><label for="imgdescription'.$attachment_value->ID.'">'._e( "Insert Image Description   ", "button_url" ).'   </label></a>';
        echo  '<a><input maxlength="160" type="text" name="imgdescription'.$attachment_value->ID.'" id="imgdescription'.$attachment_value->ID.'" value="'.button_url_get_meta( "imgdescription" .$attachment_value->ID ).'"></a>';
        echo '  </p>';
  echo '<p><a id="close-popup" data-popup-close="popup-'.$attachment_value->ID.'" href="#">Close</a></p>';
  echo ' <a id="close-popup" class="popup-close" data-popup-close="popup-'.$attachment_value->ID.'" href="#">x</a>';
  echo '</div>';
  echo '</div>';

}

}



/**
* Image gallerry button
*
* @since Spartan Gallery 1.0.2
*
* @param array  $urls           URLs to print for resource hints.
* @param string $relation_type  The relation type the URLs are printed.
* @return array $urls           URLs to print for resource hints.
*/
function button_url_save( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( ! isset( $_POST['button_url_nonce'] ) || ! wp_verify_nonce( $_POST['button_url_nonce'], '_button_url_nonce' ) ) return;
	if ( ! current_user_can( 'edit_post', $post_id ) ) return;

				$args = array(
					'post_type'   => 'attachment',
					'numberposts' => -1,
					//'post_parent' => $page_id,
					'post_status' => null,
					'meta_query'  => array(
						array(
							'key'     => 'spartan_gallery',
							'compare' => '=',
						)
					)

				);

				$attachments = get_posts( $args );
        foreach ( (array) $attachments as $attachments_id => $attachment_value ) {

	        if ( sanitize_text_field(  isset($_POST['button_url_buttonurl'.$attachment_value->ID.'']) ) )
	      		update_post_meta( $post_id, 'button_url_buttonurl'.$attachment_value->ID.'', $_POST['button_url_buttonurl'.$attachment_value->ID.''] );

	        if ( sanitize_text_field( isset($_POST['button_url_buttontitle'.$attachment_value->ID.''] ) ) )
	      		update_post_meta( $post_id, 'button_url_buttontitle'.$attachment_value->ID.'', $_POST['button_url_buttontitle'.$attachment_value->ID.''] );

	        if ( sanitize_text_field( isset($_POST['imgtitle'.$attachment_value->ID.'']) ) )
	      		update_post_meta( $post_id, 'imgtitle'.$attachment_value->ID.'', $_POST['imgtitle'.$attachment_value->ID.''] );

	        if ( sanitize_text_field(isset($_POST['imgdescription'.$attachment_value->ID.'']) ) )
	      		update_post_meta( $post_id, 'imgdescription'.$attachment_value->ID.'', $_POST['imgdescription'.$attachment_value->ID.''] );
	      }

}
add_action( 'save_post', 'button_url_save' );
