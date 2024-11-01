<?php
if ( ! defined( 'WPINC' ) ) {

    die;

}


Class Spartan_Gallery_Hexagon {


  static function hexagon_html_container( $attachments ) {


    $output = '';
    $output .= '<div class="spartan-gallery-wrapper" style="position: relative;width: 100%;" >';
      $output .= '<div class="masonary" >';
        $output .= '<ul>';
          foreach ( $attachments as $attachments_id => $attachments_val ) {
                $img_size = array( '120', '160', '180', '240', '280', '320'   );
                $image_options = get_post_meta( $attachments_val->post_parent , 'spartan-gallery-meta', true ); // array
                $image_attributes = wp_get_attachment_image_src( $attachments_val->ID , $size = $image_options['thumbnail_size']  );
                $output .=  '<li class="hex">';
                  $output .=    '<a class="js-img-viwer hexIn" data-caption="Title" data-id="'.$attachments_id.'" href="'.$attachments_val->guid.'">';
                          if ( $image_options['display_original'] == 'on' and $image_options['thumbnail_options'] == 'off' ) {

                            $output .= '<img style="height:100%;  width:100%;" src="'.$attachments_val->guid.'"  />';

                          } elseif ( $image_options['thumbnail_options'] == 'on' and $image_options['display_original'] == 'off' ) {

                            $output .= '<img style="height:100%;  width:100%;" src="'.$image_attributes[0].'"  />';

                          } else
                          {
                            $output .=  '<p>Image Options => "Display Original Size Image" or "Display Thumnail Size" settings are turned on or off same time</p>';

                          }
                          if( ! empty( implode(get_post_meta( get_the_ID(),"imgtitle" . $attachments_val->ID))) ) {
                            $output .= '<h1 >'.esc_html(implode(get_post_meta( get_the_ID(),"imgtitle" . $attachments_val->ID) ) ).'</h1>';
                          }

                          if( ! empty( implode(get_post_meta( get_the_ID(),"imgdescription" . $attachments_val->ID))))  {
                            $output .= '<p >'.esc_html(implode(get_post_meta( get_the_ID(),"imgdescription" . $attachments_val->ID) ) ).'</p>';
                          }

                          if( ! empty( implode(get_post_meta( get_the_ID(),"button_url_buttonurl" . $attachments_val->ID))) ) {
                            $output .=('<td colspan="3" style="background-color:#005673; text-align:right; padding: 4px 0px;">
                              <button class="spartan-gallery-img-button text" onclick="parent.open(\'' . esc_url(implode(get_post_meta( get_the_ID(),"button_url_buttonurl" . $attachments_val->ID))) . '\')" >'.esc_html(implode(get_post_meta( get_the_ID(),"button_url_buttontitle" . $attachments_val->ID) ) ).'</button></td>');
                          }

                      $output .= '</a>';
                  $output .= '</li>';
            }
          $output .= '</ul>';
        $output .= '</div>';
        $output .= '<script>';
        $output .= '';


        $output .= '</script>';
      $output .= '</div>';

    return $output;

    }
}
