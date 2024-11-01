<?php

if ( ! defined( 'WPINC' ) ) {

    die;

}


class BatchConvert {

    private $settings = null;
    private $plugin_name;
    private $plugin_version;

    public function __construct( $plugin_name, $plugin_version) {
        $this->settings = unserialize(get_option('wpb-field-settings'));
        $this->plugin_name = $plugin_name;
        $this->plugin_version = $plugin_version;
        add_action('admin_menu', array($this, 'register_page'));

        add_action( 'init', array( $this, 'func_export_all_posts' ) );
    }


    public function register_page() {

        add_submenu_page('edit.php?post_type=spartan_gallery_type', 'Export Gallery', 'Export Gallery', 'read', 'wbc-export-posts', array($this, 'render_export_page'));
        add_submenu_page('edit.php?post_type=spartan_gallery_type', 'Import Gallery', 'Import Gallery', 'read', 'wbc-import-posts', array($this, 'render_import_page'));
    }



    public function render_export_page() {
        if ($this->settings) {
            echo __('<p>This plugin will export all selected posts with the following post meta fields (with current value if available):</p>');
            echo '<ul>';
            foreach ($this->settings['meta_keys'] as $meta_key) {
                echo "<li><strong>$meta_key</strong></li>";
            }
            echo '</ul>';
            echo '<p><a href="/app01/wp-admin/edit.php?post_type=spartan_gallery_type&export_all_posts" class="spartan-gallert-export-button button">'.__('Generate CSV file').'</a></p>';
        } else {
            echo __('<p>You need configure the settings for this plugin. See Batch settings under the Tools menu.</p>');
        }
    }




    public function render_import_page() {
        if ($this->settings) {
            if (isset($_FILES['userfile'])) {
                $filename = $_FILES['userfile']['tmp_name'];
                $fh = fopen($filename, 'r');
                $counter = 0;
                $success = 0;
                while($data = fgetcsv($fh, 0, ';')) {
                    print_r( $data );
                    if ($counter) {
                        wp_update_post(array(
                            'ID' => $data[0],
                            'post_title' => utf8_encode($data[2]),
                        ));
                        $meta_key_counter = 4;
                        $success++;
                        foreach ( $this->settings['meta_keys'] as $meta_key => $meta_value ) {


                            $post_id = wp_insert_post( array(

                                            'post_status' => 'publish',
                                            'post_type' => 'spartan_gallery_type',
                                            'post_title' => $data[0],
                                            'post_status' => $data[2],
                                            'post_author' => $data[3],
                                            'meta_input'   => array(
                                                'spartan-gallery-meta' =>  array(
                                                  'image_layout_select'               => $data[4],
                                                  'spartan_gallery_uploaded_images'   => $data[5],
                                                  'spartan_gallery_attached_images'  => $data[6],
                                                  'display_original'                 => $data[7],
                                                  'image_width'                      => $data[8],
                                                  'image_height'                     => $data[9],
                                                  'image_measure_value'              => $data[10],
                                                  'thumbnail_options'                => $data[11],
                                                  'thumbnail_size'                   => $data[12],
                                                  'img_margin'                       => $data[13],
                                                  'border_width'                     => $data[14],
                                                  'border_style'                     => $data[15],
                                                  'border_color'                     => $data[16],
                                                  'display_text'                     => $data[17],
                                                  'image_height_range'               => $data[18],
                                                  'info_background_color'            => $data[19],
                                                  'container_font_size'              => $data[20],
                                                  'font_weight'                      => $data[21],
                                                  'font_transform'                   => $data[22],
                                                  'font_style'                       => $data[23],
                                                  'container_measure_value'          => $data[24],
                                                  'line_height'                      => $data[25],
                                                  'letter_spacing'                   => $data[26],
                                                  'container_settings_on_off'        => $data[27],
                                                  'container_height_range'           => $data[28],
                                                  'container_width_range'            => $data[29],
                                                  'gallery_container_measure_value'  => $data[30],
                                                  'container_background_color'       => $data[31],
                                                  'container_border_color'           => $data[32],
                                                  'container_border_range'           => $data[33],
                                                  'container_border_style'           => $data[34],
                                                  'add_extra_css'                    => $data[35],

                                            ) ),

                                        ) );


                              //$post_id = wp_insert_attachment( $data , $data[18] , $data[1]  );



                            GLOBAL $wpdb;


                            $meta_key_counter++;
                        }
                    }
                    $counter++;
                }
                echo '<p>'.__('Successfully updated <strong>')." $success ".__('posts')."!</strong></p>";
                fclose($fh);
            } else {
                echo '<p><form enctype="multipart/form-data" action="" method="POST">';
                echo '<input type="hidden" name="MAX_FILE_SIZE" value="30000">';
                echo __('Choose CSV file to upload: ').'<br><input name="userfile" type="file"><br>';
                echo '<input type="submit" class="button" value="'.__('Upload file').'">';
                echo '</form></p>';
            }
        } else {
            echo __('<p>You need configure the settings for this plugin. See Batch settings under the Tools menu.</p>');
        }
    }

    public function func_export_all_posts() {
        if(isset($_GET['export_all_posts'])) {
            $arg = array(
                    'post_type' => 'spartan_gallery_type',
                    'post_status' => 'publish',
                    'posts_per_page' => -1,
                );

            global $post;
            $arr_post = get_posts($arg);
            if ($arr_post) {

                header('Content-type: text/csv');
                header('Content-Disposition: attachment; filename="spartan_gallery_export.csv"');
                header('Pragma: no-cache');
                header('Expires: 0');

                $file = fopen('php://output', 'w');

                fputcsv($file, array('Spartan Gallery Settings '));

                foreach ($arr_post as $post_key =>  $post) {
                    setup_postdata( $post );
                    $gallery_options = get_post_meta(  $post->ID , 'spartan-gallery-meta', false ); // array


                    $args = array(
                      'post_type'   => 'attachment',
                      'numberposts' => -1,
                      'post_parent' => $post->ID,
                      'post_status' => null,
                      'meta_query'  => array(
                        array(
                          'key'     => 'spartan_gallery',
                          'compare' => '=',
                        )
                      )

                    );

                    $attachments = get_posts( $args );
                    //print_r( $attachments );


                    foreach ( $gallery_options as $key => $value ) {
                      //print $value['image_layout_select'];

                      $a[] =  array(
                              $value['image_layout_select'],
                              $value['spartan_gallery_uploaded_images'],
                              $value['spartan_gallery_attached_images'],
                              $value['display_original'],
                              $value['image_width'],
                              $value['image_height'],
                              $value['image_measure_value'],
                              $value['thumbnail_options'],
                              $value['thumbnail_size'],
                              $value['img_margin'],
                              $value['border_width'],
                              $value['border_style'],
                              $value['border_color'],
                              $value['display_text'],
                              $value['image_height_range'],
                              $value['info_background_color'],
                              $value['container_font_size'],
                              $value['font_weight'],
                              $value['font_transform'],
                              $value['font_style'],
                              $value['container_measure_value'],
                              $value['line_height'],
                              $value['letter_spacing'],
                              $value['container_settings_on_off'],
                              $value['container_height_range'],
                              $value['container_width_range'],
                              $value['gallery_container_measure_value'],
                              $value['container_background_color'],
                              $value['container_border_color'],
                              $value['container_border_range'],
                              $value['container_border_style'],
                              $value['add_extra_css'] ,
                           );
                    }

                    fputcsv($file, array( $post->post_title , $post->ID , $post->post_status, $post->post_author , $a[$post_key][0] , $a[$post_key][1] , $a[$post_key][2] , $a[$post_key][3] , $a[$post_key][4], $a[$post_key][5], $a[$post_key][6], $a[$post_key][7], $a[$post_key][8], $a[$post_key][9],
                        $a[$post_key][10], $a[$post_key][11], $a[$post_key][12], $a[$post_key][13], $a[$post_key][14], $a[$post_key][15], $a[$post_key][16], $a[$post_key][17], $a[$post_key][18], $a[$post_key][19], $a[$post_key][20], $a[$post_key][21], $a[$post_key][22], $a[$post_key][23], $a[$post_key][24], $a[$post_key][25], $a[$post_key][26], $a[$post_key][27], $a[$post_key][28], $a[$post_key][29],
                        $a[$post_key][30], $a[$post_key][31],
                    ) , ';' );
/*
                    foreach ( $attachments as $attachments_key => $attachments_value ) {

                      $attachments_array[$attachments_key] = array
                                            (
                                               $attachments_value->ID,
                                               $attachments_value->post_date,
                                               $attachments_value->post_date,
                                               $attachments_value->post_date_gmt,
                                               $attachments_value->post_content,
                                               $attachments_value->post_title,
                                               $attachments_value->post_excerpt,
                                               $attachments_value->post_status,
                                               $attachments_value->comment_status,
                                               $attachments_value->ping_status,
                                               $attachments_value->post_password,
                                               $attachments_value->post_name,
                                               $attachments_value->to_ping,
                                               $attachments_value->pinged,
                                               $attachments_value->post_modified,
                                               $attachments_value->post_modified_gmt,
                                               $attachments_value->post_content_filtered,
                                               $attachments_value->post_parent,
                                               $attachments_value->guid,
                                               $attachments_value->menu_order,
                                               $attachments_value->post_type,
                                               $attachments_value->post_mime_type,
                                               $attachments_value->comment_count,
                                               $attachments_value->filter,

                                            ); //$attachments_value;
                      fputcsv( $file, $attachments_array[$attachments_key], ';' );
                    }
*/




                }

                exit();
            }
        }
    }


}
