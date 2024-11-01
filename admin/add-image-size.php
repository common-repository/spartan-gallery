<?php
/**
 * Function to thumbnail sizes for plugin
 *
 * @since Spartan Gallery 1.0.2
 * @return void
 */
 if ( ! defined( 'WPINC' ) ) {

     die;

 }
 
add_action( 'after_setup_theme', 'wpdocs_theme_setup' );

 function wpdocs_theme_setup() {
     add_image_size( 'gallery-extra-small-thumb', 120, 120, true ); // (cropped)
     add_image_size( 'gallery-smaller-thumb', 240, 240, true ); // (cropped)
     add_image_size( 'gallery-extra-tiny-thumb', 320, 320, true ); // (cropped)
     add_image_size( 'gallery-tiny-thumb', 480, 480, true ); // (cropped)
     add_image_size( 'gallery-mobile-thumb', 640, 640, true ); // (cropped)
     add_image_size( 'gallery-medium-mobile-thumb', 480, 320, true ); // (cropped)
     add_image_size( 'gallery-small-tablet-thumb', 640, 480, true ); // (cropped)
     add_image_size( 'gallery-tablet-thumb', 720, 480, true ); // (cropped)
     add_image_size( 'gallery-extra-large-thumb', 800, 600, true ); // (cropped)
     add_image_size( 'gallery-full-thumb', 960, 720, true ); // (cropped)
     add_image_size( 'gallery-small-laptop-thumb', 1080, 720, true ); // (cropped)
     add_image_size( 'gallery-laptop-thumb', 1366, 720, true ); // (cropped)
     add_image_size( 'gallery-bigscreen-thumb', 1920, 1080, true ); // (cropped)
 }
