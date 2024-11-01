<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin
 */
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin
 * @author     Your Name <email@example.com>
 */

 if ( ! defined( 'WPINC' ) ) {

     die;

 }


class Plugin_Name_Admin {
	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;
	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}
	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/plugin-name-admin.css', array(), $this->version, 'all' );
	}
	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/plugin-name-admin.js', array( 'jquery' ), $this->version, false );
	}
    public function get_all_emails() {
        $all_users = get_users();
        $user_email_list = array();
        foreach ($all_users as $user) {
            $user_email_list[sanitize_email($user->user_email)] = sanitize_email($user->display_name);
        }
        return $user_email_list;
    }
    public function create_menu() {
        /**
         * Create a submenu page under Plugins.
         * Framework also add "Settings" to your plugin in plugins list.
         * @link https://github.com/JoeSz/Exopite-Simple-Options-Framework
         */
         /**
  * Create a submenu page under Plugins.
  * Framework also add "Settings" to your plugin in plugins list.
  * @link https://github.com/JoeSz/Exopite-Simple-Options-Framework
  */
 $config_submenu = array(
     'type'              => 'menu',                          // Required, menu or metabox
     'id'                => $this->plugin_name,              // Required, meta box id,
                                                             // unique per page, to save:
                                                             // get_option( id )
     'parent'            => 'plugins.php',                   // Required, sub page to your options page
     'submenu'           => true,                            // Required for submenu
     'title'             => 'Demo Admin Page',               //The name of this page
     'capability'        => 'manage_options',                // The capability needed to view the page
     'plugin_basename'   =>  plugin_basename( plugin_dir_path( __DIR__ ) . $this->plugin_name . '.php' ),
     // 'tabbed'            => false,                        // is tabbed or not
                                                             // Note: if only one section then
                                                             // Tabs are disabled.
     // 'multilang'         => false                         // Disable mutilang support, default: true

 );

 /*
  * To add a metabox.
  * This normally go to your functions.php or another hook
  */
 $config_metabox = array(
     /*
      * METABOX
      */
     'type'              => 'metabox',
     'id'                => $this->plugin_name . '-meta',
     'post_types'        => array( 'spartan_gallery_type' ),    // Post types to display meta box
     'context'           => 'normal',
     'priority'          => 'high',
     'title'             => 'Gallery Options',
     'capability'        => 'manage_options',              // The capability needed to view the page
     // 'tabbed'            => false,                  // Add tabs or not, default true
     // 'simple'            => true,                   // Save post meta as simple insted of an array, default false
     // 'multilang'         => true,                   // Multilang support, required for ONLY qTranslate-X and WP Multilang
                                                       // for WPML and Polilang leave it in default.
                                                       // default: false
 );

 $fields[] = array(
     'name'   => 'spartan_gallery_first_section',
     'title'  => 'Gallery Layout Options',
     'icon'   => 'dashicons-screenoptions',
     'fields' => array(


         array(
             'id'        => 'image_layout_select',
             'type'      => 'image_select',
             'title'     => 'Select Gallery Layout',
             'options'   => array(
                 'value-1' => plugins_url( '/img/FlexFreewallTable.png',  __FILE__ ),
                 'value-2' => plugins_url( '/img/ImageFreewallGrid.png',  __FILE__ ),
                 'value-3' => plugins_url( 'img/NestedFreewallGrid.png',  __FILE__ ),
                 'value-4' => plugins_url( '/img/PinterestFreewallGrid.png',  __FILE__ ),
								 'value-5' => plugins_url( '/img/hexagon_layout.jpg',  __FILE__ ),
								 'value-6' => plugins_url( '/img/spartan_3D_layout.png',  __FILE__ ),

             ),
             'radio'        => true,
             'default'      => 'value-1',
         ),

/*
         array(
             'type'    => 'backup',
             'title'   => esc_html__( 'Backup', 'exopite-seo-core' ),
         ),
*/
     )

 );
 $fields[] = array(
     'name'   => 'spartan_gallery_second_section',
     'title'  => 'Upload Images',
     'icon'   => 'dashicons-images-alt2',
     'fields' => array(

         array(
             'id'      => 'spartan_gallery_uploaded_images',
             'type'    => 'upload',
             'title'   => 'Upload',
             'options' => array(
                 'attach'                    => true, // attach to post (only in metabox)
                 'filecount'                 => '101',
                  //'allowed'                   => array( 'png', 'jpeg' ),
                 // 'delete-enabled'            => false,
                 // 'delete-force-confirm'      => true,
                 // 'retry-enable-auto'         => true,
                 // 'retry-max-auto-attempts'   => 3,
                 // 'retry-auto-attempt-delay'  => 3,
                  'auto-upload'               => true,
             ),
         ),
         array(
             'id'      => 'spartan_gallery_attached_images',
             'type'    => 'attached',
             'title'   => 'Attached',
             'options' => array(
                 //'type' => 'image', // attach to post (only in metabox)
             ),
         ),
     )
 );

 $fields[] = array(
     'name'   => 'image_options',
     'title'  => 'Image Options',
     'icon'   => 'dashicons-welcome-widgets-menus',
     'fields' => array(
/*
          array(
             'type'    => 'content',
             'class'   => 'class-name', // for all fieds
             'title'   => 'Content Title',
             'content' => '<p>Etiam consectetur commodo ullamcorper. Donec quis diam nulla. Maecenas at mi molestie ex aliquet dignissim a in tortor. Sed in nisl ac mi rutrum feugiat ac sed sem. Nullam tristique ex a tempus volutpat. Sed ut placerat nibh, a iaculis risus. Aliquam sit amet erat vel nunc feugiat viverra. Mauris aliquam arcu in dolor volutpat, sed tempor tellus dignissim.</p><p>Quisque nec lectus vitae velit commodo condimentum ut nec mi. Cras ut ultricies dui. Nam pretium <a href="#">rutrum eros</a> ac facilisis. Morbi vulputate vitae risus ac varius. Quisque sed accumsan diam. Sed elementum eros lectus, et egestas ante hendrerit eu. Proin porta, enim nec dignissim commodo, odio orci maximus tortor, iaculis congue felis velit sed lorem. </p>',
             'before' => 'Before Text',
             'after'  => 'After Text',
         ),
*/
				 array(
					 'id'      => 'display_original',
					 'type'    => 'button_bar',
					 'title'   => 'Display Adjustable Image ',
					 'options' => array(
						 'on'   => 'ON',
						 'off'   => 'OFF',
						 //'three' => 'Three',
					 ),
					 'default' => 'off',
				 ),
				 array(
						 'id'      => 'image_width',
						 'type'    => 'number',
						 'title'   => 'Image Width',
						 'default' => '150',
						 // 'unit'    => '$',
						 'after'   => ' <i class="text-muted">px</i>',
						 'min'     => '50',
						 'max'     => '600',
						 'step'    => '2',
				 ),
				 array(
						 'id'      => 'image_height',
						 'type'    => 'number',
						 'title'   => 'Image Height',
						 'default' => '150',
						 // 'unit'    => '$',
						 'after'   => ' <i class="text-muted">px</i>',
						 'min'     => '50',
						 'max'     => '600',
						 'step'    => '2',
				 ),
				 array(
							'id'             => 'image_measure_value',
							'type'           => 'select',
							'title'          => 'Img Measure value',
							'options'        => array(
									'px'     => 'px',
									'%'    => '%',
									'vh'         => 'vh/vw',
									'rem'        => 'rem',
							),
							'default_option' => 'Select Image measure value',
							'default'     => 'px',
					 ),
				 array(
					 'id'      => 'thumbnail_options',
					 'type'    => 'button_bar',
					 'title'   => 'Display Thumnail Size ',
					 'options' => array(
						 'on'    => 'ON',
						 'off'   => 'OFF',
						 //'three' => 'Three',
					 ),
					 'default' => 'on',
				 ),
				 array(
							'id'             => 'thumbnail_size',
							'type'           => 'select',
							'title'          => 'Select Thumbnail Size',
							'options'        => array(
									'thumbnail'          => 'Thumbnail (default 150px x 150px max)',
									'medium'     => 'Medium resolution (default 300px x 300px max)',
									'medium_large'   => 'Medium Large resolution (default 768px x 0px max)',
									'large'        => 'Large resolution (default 1024px x 1024px max)',
									'original'        => 'Original image resolution (unmodified)',
							),
							'default_option' => 'Select Image Thumbnail Size',
							'default'     => 'medium_large',
					 ),
					 array(
							 'id'      => 'img_margin',
							 'type'    => 'range',
							 'title'   => 'Image Margin',
							 'default' => '20',
							 // 'unit'    => '$',
							 'after'   => ' <i class="text-muted"></i>',
							 'min'     => '0',
							 'max'     => '100',
					 ),

				 array(
                 'type'    => 'content',
                 'class'   => 'class-name', // for all fieds
                 'title'   => ' ',
                 'content' => '<h1>Image Style Settings</h1>',
                 //'before' => 'Before Text',
                 //'after'  => 'After Text',
             ),
					 array(
							 'id'      => 'border_width',
							 'type'    => 'range',
							 'title'   => 'Border Width',
							 'default' => '1',
							 // 'unit'    => '$',
							 'after'   => ' <i class="text-muted">px</i>',
							 'min'     => '0',
							 'max'     => '100',
					 ),
					 array(
								'id'             => 'border_style',
								'type'           => 'select',
								'title'          => 'select Border Style',
								'options'        => array(
										'dotted'          => 'dotted',
										'dashed'     => 'dashed',
										'solid'   => 'solid',
										'double'        => 'double',
										'groove'          => 'groove',
										'ridge'     => 'ridge',
										'inset'   => 'inset',
										'outset'        => 'outset',
										'none'          => 'none',
										'hidden'     => 'hidden',

								),
								'default_option' => 'Select Border Style',
								'default'     => '',
						 ),
						 array(
								 'id'     => 'border_color',
								 'type'   => 'color',
								 'title'  => 'Border Color',
								 'rgba'   => true,
						 ),


     ),
 );
 $fields[] = array(
     'name'   => 'button_style_options',
     'title'  => 'Text Style Options',
     'icon'   => 'dashicons-admin-settings',
     'fields' => array(
       array(
           'type'    => 'content',
           'content' => 'Third Section',
       ),
			 array(
				 'id'      => 'display_text',
				 'type'    => 'button_bar',
				 'title'   => 'Display Text Under Image',
				 'options' => array(
					 'on'   => 'ON',
					 'off'   => 'OFF',
				 ),
				 'default' => 'off',
			 ),
			 array(
					 'id'      => 'image_height_range',
					 'type'    => 'range',
					 'title'   => 'Image Height',
					 'default' => '50',
					 // 'unit'    => '$',
					 'after'   => ' <i class="text-muted">Set Image height after text is turned on example: 65%</i>',
					 'min'     => '0',
					 'max'     => '100',
			 ),
		 	array(
						'type'    => 'content',
						'class'   => 'class-name', // for all fieds
						'title'   => ' ',
						'content' => '<h1>Gallery Text Options</h1>',
						//'before' => 'Before Text',
						//'after'  => 'After Text',
				),
				array(
						'id'     => 'info_background_color',
						'type'   => 'color',
						'title'  => 'Text Container Background Color',
						'rgba'   => true,
				),
			 array(
						'id'      => 'container_font_size',
						'type'    => 'range',
						'title'   => 'Font Size',
						'default' => '18',
						// 'unit'    => '$',
						'after'   => '',
						'min'     => '1',
						'max'     => '100',
				),
				array(
						 'id'             => 'font_weight',
						 'type'           => 'select',
						 'title'          => 'Font Weight',
						 'options'        => array(
								 '100'        => '100',
								 '200'        => '200',
								 '300'         => '300',
								 '400'        => '400',
								 '500'        => '500',
								 '600'        => '600',
								 '700'         => '700',
								 '800'        => '800',
								 '900'        => '800',
								 'normal'        => 'Normal',
								 'bold'        => 'Bold',
						 ),
						 'default_option' => 'Select font weight',
						 'default'     => '%',
					),
					array(
							 'id'             => 'font_transform',
							 'type'           => 'select',
							 'title'          => 'Transform',
							 'options'        => array(
									 'uppercase'      => 'Uppercase',
									 'lowercase'      => 'Lowercase',
									 'capitalise'     => 'Capitalise',
									 'normal'         => 'Normal',
							 ),
							 'default_option' => 'Select Transform',
							 'default'     => '%',
						),
						array(
								 'id'             => 'font_style',
								 'type'           => 'select',
								 'title'          => 'Font Style',
								 'options'        => array(
										 'default'     => 'Default',
										 'normal'     => 'Normal',
										 'italic'         => 'Italic',
								 ),
								 'default_option' => 'Select font style',
								 'default'     => '%',
							),
						array(
								 'id'             => 'container_measure_value',
								 'type'           => 'select',
								 'title'          => 'Decoration',
								 'options'        => array(
										 'underline'     => 'Underline',
										 'overline'      => 'Overline',
										 'line-through'  => 'Line Through',
										 'none'          => 'none',
								 ),
								 'default_option' => 'Select decoration',
								 'default'     => '%',
							),
						array(
								 'id'      => 'line_height',
								 'type'    => 'range',
								 'title'   => 'Line Height',
								 'default' => '0',
								 // 'unit'    => '$',
								 'after'   => '',
								 'min'     => '0.1',
								 'max'     => '5.0',
								 'step'    => '0.1',
						 ),
						 array(
									'id'      => 'letter_spacing',
									'type'    => 'range',
									'title'   => 'Letter Spacing',
									'default' => '0',
									// 'unit'    => '$',
									'after'   => '',
									'min'     => '0.1',
									'max'     => '5.0',
									'step'    => '0.1',
							),

     ),
 );
 $fields[] = array(
		 'name'   => 'gallery_container_settings',
		 'title'  => 'Gallery Container',
		 'icon'   => 'dashicons-tablet',
		 'fields' => array(
				 array(
						 'type'    => 'content',
						 'content' => 'Gallery Container Settings',
				 ),
				array(
					'id'      => 'container_settings_on_off',
					'type'    => 'button_bar',
					'title'   => 'Turn Setting On/Off',
					'options' => array(
						'on'   => 'ON',
						'off'   => 'OFF',
						//'three' => 'Three',
					),
					'default' => 'on',
				),
				array(
						'id'      => 'container_height_range',
						'type'    => 'range',
						'title'   => 'Container Height',
						'default' => '100',
						// 'unit'    => '$',
						'after'   => '',
						'min'     => '0',
						'max'     => '1000',
				),
				array(
						'id'      => 'container_width_range',
						'type'    => 'range',
						'title'   => 'Container Width',
						'default' => '100',
						// 'unit'    => '$',
						'after'   => '',
						'min'     => '0',
						'max'     => '1000',
				),
				array(
						 'id'             => 'gallery_container_measure_value',
						 'type'           => 'select',
						 'title'          => 'Measure value',
						 'options'        => array(
								 'px'     => 'px',
								 '%'    => '%',
								 'vh'         => 'vh/vw',
								 'rem'        => 'rem',
						 ),
						 'default_option' => 'Select container box measure value',
						 'default'     => '%',
					),
				array(
						'id'     => 'container_background_color',
						'type'   => 'color',
						'title'  => 'Background Color',
						'rgba'   => true,
				),
				array(
								'type'    => 'content',
								'class'   => 'class-name', // for all fieds
								'title'   => '',
								'content' => '<h1>Container Border Color</h1>',
								//'before' => 'Before Text',
								//'after'  => 'After Text',
						),
				array(
						'id'     => 'container_border_color',
						'type'   => 'color',
						'title'  => 'Border Color',
						'rgba'   => true,
				),
				array(
						'id'      => 'container_border_range',
						'type'    => 'range',
						'title'   => 'Border height',
						'default' => '0',
						// 'unit'    => '$',
						'after'   => ' <i class="text-muted">px</i>',
						'min'     => '0',
						'max'     => '20',
				),
				array(
						 'id'             => 'container_border_style',
						 'type'           => 'select',
						 'title'          => 'select Border Style',
						 'options'        => array(
								 'dotted'          => 'dotted',
								 'dashed'     => 'dashed',
								 'solid'   => 'solid',
								 'double'        => 'double',
								 'groove'          => 'groove',
								 'ridge'     => 'ridge',
								 'inset'   => 'inset',
								 'outset'        => 'outset',
								 'none'          => 'none',
								 'hidden'     => 'hidden',

						 ),
						 'default_option' => 'Select Border Style',
						 'default'     => '',
					),
		 ),
 );
  $fields[] = array(
     'name'   => 'insert_extra_css',
     'title'  => 'Insert Extra CSS',
     'icon'   => 'dashicons-welcome-write-blog',
     'fields' => array(
         array(
             'id'      => 'add_extra_css',
             'type'    => 'ace_editor',
             'title'   => 'ACE Editor',
             'options' => array(
                 'theme'                     => 'ace/theme/chrome',
                 'mode'                      => 'css',
                 'showGutter'                => true,
                 'showPrintMargin'           => true,
                 'enableBasicAutocompletion' => true,
                 'enableSnippets'            => true,
                 'enableLiveAutocompletion'  => true,
             ),
             'attributes'    => array(
                 'style'        => 'height: 300px; max-width: 700px;',
             ),
         ),

     ),
 );




 //$options_panel = new Exopite_Simple_Options_Framework( $config_submenu, $fields );
 $metabox_panel = new Exopite_Simple_Options_Framework( $config_metabox, $fields );
    }
    // Modify columns in customers list in admin area
    public function admin_list_edit_columns( $columns ) {
        // Remove unnecessary columns
        // unset(
        //     $columns['author'],
        //     $columns['comments']
        // );
        // Rename title and add ID and Address
        $columns['text_1'] = __( 'Text', 'plugin-name' );
        $columns['color_2'] = __( 'Color', 'plugin-name' );
        $columns['date_2'] = __( 'Date', 'plugin-name' );
        /*
         * Rearrange column order
         *
         * Now define a new order. you need to look up the column
         * names in the HTML of the admin interface HTML of the table header.
         *
         *     "cb" is the "select all" checkbox.
         *     "title" is the title column.
         *     "date" is the date column.
         *     "icl_translations" comes from a plugin (in this case, WPML).
         *
         * change the order of the names to change the order of the columns.
         *
         * @link http://wordpress.stackexchange.com/questions/8427/change-order-of-custom-columns-for-edit-panels
         */
        $customOrder = array('cb', 'title', 'text_1', 'color_2', 'date_2', 'author', 'comments', 'icl_translations', 'date');
        /*
         * return a new column array to wordpress.
         * order is the exactly like you set in $customOrder.
         */
        foreach ($customOrder as $column_name)
            $rearranged[$column_name] = $columns[$column_name];
        return $rearranged;
    }
    // Populate new columns in customers list in admin area
    public function admin_list_custom_columns( $column ) {
        /*
        'user_login' => 'js@markatus.de',
        'arbeitszeiterfassung' => 'no',
        'soll_stunden' => '',
        'anstellung' => 'vollzeit',
        'festlegung_zeitraum' => 'abreitstage_pro_woche',
        'verwaltung_jahresurlaub' => 'ja',
        'code_fuer_erfassungsbestaetigung' => '',
        'team' => 'markatus',
         */
        global $post;
        $custom = get_post_custom();
        $meta = maybe_unserialize( $custom[$this->plugin_name . '-meta'][0] );
        // Populate column form meta
        switch ($column) {
            case "text_1":
                // echo var_export( $meta, true );
                echo $meta["text_1"];
                break;
            case "color_2":
                echo $meta["color_2"];
                break;
            case "date_2":
                echo $meta["date_2"];
                break;
        }
    }
}


$r = new Plugin_Name_Admin('spartan-gallery', '1.0.0');
$r->create_menu();
