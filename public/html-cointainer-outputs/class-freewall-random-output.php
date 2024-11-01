<?php
if ( ! defined( 'WPINC' ) ) {

    die;

}


Class Freewall_Random_Container
{


      static function display_random_container( $attachments  )
      {

        $html = '';
        $html =  '  <div  class="spartan-gallery-wrapper" >';
          $html = '  <div id="freewall-random" class="masonary" >'; //data-fixSize="true"
          // Loop through them and output an image
            $img_size = array( '120', '160', '180', '240', '280', '320'   );

            foreach ( (array) $attachments as $attachment_id => $attachment_val ) {

                $img_size = array( '120', '160', '180', '240', '280', '320'   );
                $image_options = get_post_meta( $attachment_val->post_parent , 'spartan-gallery-meta', true ); // array
                $image_attributes = wp_get_attachment_image_src( $attachment_val->ID , $size = $image_options['thumbnail_size']  );

                if ( $image_options['display_original'] == 'on' xor $image_options['thumbnail_options'] == 'on' ) {
                  $html .=  '<div  class="freewall-brick brick"  data-width="'.$img_size[array_rand( $img_size , 1 )].'" data-height="'.$img_size[array_rand( $img_size , 1 )].'" data-delay="'.$attachment_id.'"   >';
                }

                $html .=  '<a  href="'.$attachment_val->guid.'"  class="js-img-viwer img-true-location" data-caption="" data-id="'.$attachment_id.'" >';
                    //=====================  Random width layout   =============================
                    if ( $image_options['display_original'] == 'on' and $image_options['thumbnail_options'] == 'off' ) {

                      $html .= '<img class="image" style="height:240px;  width:100%;" src="'.$attachment_val->guid.'"  />';

                    } elseif ( $image_options['thumbnail_options'] == 'on' and $image_options['display_original'] == 'off' ) {

                      $html .= '<img style="height:240px;  width:100%;" src="'.$image_attributes[0].'"  />';

                    } else
                    {
                      $text =  '<p>Image Options => "Display Original Size Image" or "Display Thumnail Size" settings are turned on or off same time</p>';
                      print $text;
                      return;
                    }

                    $s = get_post_meta( get_the_ID(),"imgtitle" . $attachment_val->ID, true );

                    if ( ! empty( $s[$attachment_id] ) and 'on' == $image_options['display_text'] ) {
                        if( 'on' == $image_options['display_text'] ) {
                            $html .= '<style>
                              .image
                              {
                                min-height: '.$image_options['image_height_range'].'% !important;
                              }
                              .info
    													{
    														max-height: calc( 100% - '.$image_options['image_height_range'].'% ) !important;
                                background-color: '.$image_options['info_background_color'].';
                                position: relative;
    													}
                            </style>';
                            //break;
                          }

                        $html .= '<div class="info" >';

                            if( ! empty( implode(get_post_meta( get_the_ID(),"imgtitle" . $attachment_val->ID))) ) {
                              $html .= '<h4 class="text spartan-gallery-img-title" >'.esc_html(implode(get_post_meta( get_the_ID(),"imgtitle" . $attachment_val->ID) ) ).'</h4>';
                            }
                            if( ! empty( implode(get_post_meta( get_the_ID(),"imgdescription" . $attachment_val->ID))))  {
                              $html .= '<p class="text spartan-gallery-img-description" >'.esc_html(implode(get_post_meta( get_the_ID(),"imgdescription" . $attachment_val->ID) ) ).'</p>';
                            }
                            if( ! empty( implode(get_post_meta( get_the_ID(),"button_url_buttonurl" . $attachment_val->ID))) ) {
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




          $html .= '
              <script>
                  jQuery( document ).ready( function( $ ){
                  // Random width layout
                    var Imagewall = new Freewall("#freewall-random");
                    Imagewall.reset({
                      selector: ".freewall-brick",
                      animate: true,
                      cellW: 200,
                      cellH: "auto",
                      gutterY: '.$image_options["img_margin"].',
                      gutterX: '.$image_options["img_margin"].',
                      onResize: function() {
                        Imagewall.fitWidth();
                      }
                    });
                    $( document ).ready(function() {
                    Imagewall.fitWidth();

                    });
                  });
              </script>';

          return $html;

      }




}
