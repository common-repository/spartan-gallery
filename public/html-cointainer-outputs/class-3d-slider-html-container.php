<?php
if ( ! defined( 'WPINC' ) ) {

    die;

}


Class ThreeD_Image_Slider
{

  static function ThreeDImageSlidet_Html_container( $attachments )
  {


    $output = '';
    $output .= '<div class="spartan-gallery-wrapper w-gallery">';
      $output .= '<section id="responsiveGallery-container" class="responsiveGallery-container">';
        $output .= '<a class="responsiveGallery-btn responsiveGallery-btn_prev" href="javascript:void(0);"></a>';
        $output .= '<a class="responsiveGallery-btn responsiveGallery-btn_next" href="javascript:void(0);"></a>';
          $output .= '<ul class="responsiveGallery-wrapper">';
          if ( isset( $attachments ) && ! empty( $attachments )  )
          {
            foreach ( $attachments as $attachments_id => $attachment_val ) {

              $img_size = array( '120', '160', '180', '240', '280', '320'   );
              $image_options = get_post_meta( $attachment_val->post_parent , 'spartan-gallery-meta', true ); // array
              $image_attributes = wp_get_attachment_image_src( $attachment_val->ID , $size = $image_options['thumbnail_size']  );

              $output .= '<li href="'.$attachment_val->guid.'"  class="js-img-viwer img-true-location responsiveGallery-item" data-caption="" data-id="'.$attachments_id.'">';

                if ( $image_options['display_original'] == 'on' and $image_options['thumbnail_options'] == 'off' ) {
                  $output .= '<a href="#" class="responsivGallery-link">';
                    $output .= '<img style="height:'.$image_options['image_height'].''.$image_options['image_measure_value'].';  width:'.$image_options['image_width'].''.$image_options['image_measure_value'].';" src="'.$attachment_val->guid.'"  />';
                  $output .= '</a>';
                } elseif ( $image_options['thumbnail_options'] == 'on' and $image_options['display_original'] == 'off' ) {
                  $output .= '<a href="#" class="responsivGallery-link">';
                    $output .= '<img style="height:'.$image_options['image_height'].''.$image_options['image_measure_value'].';  width:'.$image_options['image_width'].''.$image_options['image_measure_value'].';" src="'.$image_attributes[0].'"  />';
                  $output .= '</a>';
                } else
                {
                  $output .=  '<p>Image Options => "Display Original Size Image" or "Display Thumnail Size" settings are turned on or off same time</p>';
                  //print $text;

                }
                $output .= '<div style="color: black;" class="w-responsivGallery-info">';
                  if( ! empty( implode(get_post_meta( get_the_ID(),"imgtitle" . $attachment_val->ID))) ) {
                    $output .= '<h4 class="text spartan-gallery-img-title" >'.esc_html(implode(get_post_meta( get_the_ID(),"imgtitle" . $attachment_val->ID) ) ).'</h4>';
                  }
                  if( ! empty( implode(get_post_meta( get_the_ID(),"imgdescription" . $attachment_val->ID))))  {
                    $output .= '<p class="text spartan-gallery-img-description" >'.esc_html(implode(get_post_meta( get_the_ID(),"imgdescription" . $attachment_val->ID) ) ).'</p>';
                  }
                  if( ! empty( implode(get_post_meta( get_the_ID(),"button_url_buttonurl" . $attachment_val->ID))) ) {
                    $output .= ('<td colspan="3" style="background-color:#005673; text-align:right; padding: 4px 0px;">
                      <button class="spartan-gallery-img-button text" onclick="parent.open(\'' . esc_url(implode(get_post_meta( get_the_ID(),"button_url_buttonurl" . $attachment_val->ID))) . '\')" >'.esc_html(implode(get_post_meta( get_the_ID(),"button_url_buttontitle" . $attachment_val->ID) ) ).'</button></td>');
                  }
                $output .= '</div>';
              $output .= '</li>';

            }
          }
          $output .= '</ul>';
    $output .= '</section>';
  $output .= '</div>';

  return $output;




  }


}
