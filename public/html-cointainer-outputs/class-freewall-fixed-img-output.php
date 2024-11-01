<?php
if ( ! defined( 'WPINC' ) ) {

    die;

}


Class Freewall_Fixed_Img_Container
{


      static function display_fixed_img_container( $attachments  )
      {

        $html = '';
        $html .= '  <div  class="spartan-gallery-wrapper" >';
          $html .= '  <div id="freewall" class="masonary" >'; //data-fixSize="true"
          // Loop through them and output an image

            foreach ( (array) $attachments as $attachment_id => $attachment_val ) {

              $img_size = array( '120', '160', '180', '240', '280', '320'   );
              $image_options = get_post_meta( $attachment_val->post_parent , 'spartan-gallery-meta', true ); // array
              $image_attributes = wp_get_attachment_image_src( $attachment_val->ID , $size = $image_options['thumbnail_size']  );

              if ( $image_options['display_original'] == 'on' xor $image_options['thumbnail_options'] == 'on' ) {
                $html .=  '<div  class="freewall-brick brick overlay"  data-width="'.$image_options['image_width'].'" data-height="'.$image_options['image_height'].'" data-delay="'.$attachment_id.'"   >';
              }

              $html .=  '<a  href="'.$attachment_val->guid.'"  class="js-img-viwer img-true-location container" data-caption="" data-id="'.$attachment_id.'" >';
                  //=====================  Fixed Image layout   =============================
                  if ( $image_options['display_original'] == 'on' and $image_options['thumbnail_options'] == 'off' ) {
                    $html .= '<img class="image" style="height:100%;  width:100%;" src="'.$attachment_val->guid.'"  />';
                  } elseif ( $image_options['thumbnail_options'] == 'on' and $image_options['display_original'] == 'off' ) {
                    $html .= '<img class="image" style="height:100%;  width:100%;"  src="'.$image_attributes[0].'"  />';
                  } else
                  {
                    $text =  '<p>Image Options => "Display Original Size Image" or "Display Thumnail Size" settings are turned on or off same time</p>';
                    print $text;
                    return;
                  }


                  $s = get_post_meta( get_the_ID(),"imgtitle" . $attachment_val->ID, true );

                  if ( ! empty( $s ) and 'on' == $image_options['display_text'] ) {
                      if( 'on' == $image_options['display_text'] ) {
                          $html .= '<style>
                            .image
                            {
                              height: '.$image_options['image_height_range'].'% !important;
                            }
                            .info
                            {
                              height: calc( 100% - '.$image_options['image_height_range'].'% ) !important;
                              background-color: '.$image_options['info_background_color'].';
                              position: relative;
                            }
                          </style>';
                          //break;
                        }

                      $html .= '<div class="info" >';
            							if(! empty( implode(get_post_meta( get_the_ID(),"imgtitle" . $attachment_val->ID))) ) {
            								$html .= '<h4 class="text spartan-gallery-img-title" >'.esc_html(implode(get_post_meta( get_the_ID(),"imgtitle" . $attachment_val->ID) ) ).'</h4>';
            							}
            							if(! empty( implode(get_post_meta( get_the_ID(),"imgdescription" . $attachment_val->ID))))  {
            								$html .= '<p class="text spartan-gallery-img-description" >'.esc_html(implode(get_post_meta( get_the_ID(),"imgdescription" . $attachment_val->ID) ) ).'</p>';
            							}
            							if(! empty( implode(get_post_meta( get_the_ID(),"button_url_buttonurl" . $attachment_val->ID))) ) {
            								$html .= ('<td colspan="3" style="background-color:#005673; text-align:right; padding: 4px 0px;">
            		  						<button class="spartan-gallery-img-button text" onclick="parent.open(\'' . esc_url(implode(get_post_meta( get_the_ID(),"button_url_buttonurl" . $attachment_val->ID))) . '\')" >'.esc_html(implode(get_post_meta( get_the_ID(),"button_url_buttontitle" . $attachment_val->ID) ) ).'</button></td>');
            							}
        						   $html .= '</div>';

                    }

              $html .= '</a>';



            if ( $image_options['display_original'] == 'on' xor $image_options['thumbnail_options'] == 'on' ) {
              $html .= '</div>';
            }


            }
            $html .= '</div>';
          $html .= '</div>';



          $html .= '';
          $html .= '<script>';
            $html .= 'jQuery( document ).ready( function( $ ){';

              // chaotic layout
                $html .= '$(".freewall-brick").each(function() {';
                    $html .= 'var wall = new Freewall("#freewall");';
                    $html .= 'wall.reset({';
                        $html .= 'animate: true,';
                        //$script .='cellW: 100,';
                        //$script .='cellH: 100,';
                        //fixSize: 1,
                        $html .= 'gutterY: '.$image_options["img_margin"].',';
                        $html .= 'gutterX: '.$image_options["img_margin"].',';
                        $html .= 'onResize: function() {';
                            $html .= 'wall.fitWidth();';
                        $html .= '}';
                    $html .= '});';
                    $html .=  'wall.addCustomEvent("onBlockLoad", function(setting) {';
                        $html .= 'console.log(setting);';
                    $html .= '});';
                    $html .= 'wall.fitWidth();';
                $html .= '});';

            $html .= ' });';

           $html .= '</script>';

           return $html;
      }



}
