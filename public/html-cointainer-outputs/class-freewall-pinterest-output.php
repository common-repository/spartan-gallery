<?php
if ( ! defined( 'WPINC' ) ) {

    die;

}


Class Freewall_Pinterest_Container
{

      static function display_pinterest_container( $attachments  )
      {

        $html = '';
        $html .= '  <div  class="spartan-gallery-wrapper" >';
          $html .= '  <div id="freewall-pinterest" class="masonary" >'; //data-fixSize="true"
          // Loop through them and output an image
            $img_size = array( '120', '160', '180', '240', '280', '320'   );

            foreach ( (array) $attachments as $attachment_id => $attachment_val ) {

                $img_size = array( '120', '160', '180', '240', '280', '320'   );
                $image_options = get_post_meta( $attachment_val->post_parent , 'spartan-gallery-meta', true ); // array
                $image_attributes = wp_get_attachment_image_src( $attachment_val->ID , $size = $image_options['thumbnail_size']  );

                if ( $image_options['display_original'] == 'on' xor $image_options['thumbnail_options'] == 'on' ) {
                  //echo  '<div  class="freewall-brick brick overlay"  data-width="'.$image_options['image_width'].'" data-height="'.$image_options['image_height'].'" data-delay="'.$attachment_id.'"   >';
                  $html .=  '<div  class="freewall-brick-pinterest brick"  data-width="'.$img_size[array_rand( $img_size , 1 )].'" data-height="'.$img_size[array_rand( $img_size , 1 )].'" data-delay="'.$attachment_id.'"   >';
                }

                $html .=  '<a  href="'.$attachment_val->guid.'"  class="js-img-viwer img-true-location" data-caption="" data-id="'.$attachment_id.'" >';
                    //=====================    PINTEREST lAYOUT   =============================
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


                    $s = get_post_meta( get_the_ID(), "imgtitle" . $attachment_val->ID, true );

                    if (  ! empty( $s ) and  'on' == $image_options['display_text'] )  {


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

            if( 'on' == $image_options['display_text'] ) {
                $html .= '<style>
                  .image
                  {
                    max-height: '.$image_options['image_height_range'].'% !important;
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
            $html .= '</div>';
          $html .= '</div>';


            $html .= '<script>';
            $html .= 'jQuery( document ).ready( function( $ ){';


              // Pinterest Layout
              $html .= '$(".freewall-brick-pinterest").each(function() {';
                $html .= 'var wall = new Freewall("#freewall-pinterest");';
                  $html .= 'wall.reset({';
                    $html .= 'selector: ".brick",';
                    $html .= 'animate: false,';
                    $html .= 'cellW: 300,';
                    $html .= 'cellH: "auto",';
                    $html .= 'gutterY:'.  $image_options['img_margin'].',';
                    $html .= 'gutterX:'.  $image_options["img_margin"].',';

                  $html .= '});';

                  $html .= 'wall.container.find(".brick img").load(function() {';
                    $html .= 'wall.fitWidth();';
                  $html .= '});';
              $html .= '});';



            $html .= '});';

            $html .= '</script>';

            return $html;

      }



      static function init_freewall_random_javascript()
      {
        $html .= '';
        $html .= '<script>';
          $html .= 'jQuery( document ).ready( function( $ ){';
            $html .= '$(".freewall-brick").each(function() {';
              $html .= 'var wall = new Freewall("#freewall");';
                $html .= 'wall.reset({';
                  $html .= 'selector: "".brick",';
                  $html .= 'animate: true,';
                  $html .= 'cellW: 240,';
                  $html .= 'cellH: "auto",';
                  $html .= 'gutterY: 20,';
                  $html .= 'gutterX: 20,';
                  $html .= 'onResize: function() {';
                  $html .= 'wall.fitWidth();';
                  $html .= '}';
                  $html .= '});';

                  $html .= 'wall.container.find(".brick img").load(function() {';
                  $html .= 'wall.fitWidth();';
                $html .= '});';
            $html .= '});';
          $html .= '});';
        $html .= '</script>';

        return  $html;

        //print_r( $script );
      }





}
