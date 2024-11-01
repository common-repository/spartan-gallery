<?php
/**
 * Spartan Gallery Plugin custon solumns for post type
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
* Post Columns
*
* @since Spartan Gallery 1.0.2
*
* @param array  $urls           URLs to print for resource hints.
* @param string $relation_type  The relation type the URLs are printed.
* @return array $urls           URLs to print for resource hints.
*/


function gallery_get_featured_image($post_ID){
 $post_thumbnail_id = get_post_thumbnail_id($post_ID);
 if ($post_thumbnail_id){
  $post_thumbnail_img = wp_get_attachment_image_src($post_thumbnail_id, 'featured_preview');
  return $post_thumbnail_img[0];
 }
}




/**
* Post Columns
*
* @since Spartan Gallery 1.0.2
*
* @param array  $urls           URLs to print for resource hints.
* @param string $relation_type  The relation type the URLs are printed.
* @return array $urls           URLs to print for resource hints.
*/
function gallery_columns_head($defaults) {
 $defaults['featured_image'] = 'Gallery Shortcode';
 return $defaults;
}




/**
* Post Columns
*
* @since Spartan Gallery 1.0.2
*
* @param array  $urls           URLs to print for resource hints.
* @param string $relation_type  The relation type the URLs are printed.
* @return array $urls           URLs to print for resource hints.
*/
function gallery_columns_content($column_name, $post_ID) {
 if ($column_name == 'featured_image') {
  $post_featured_image = gallery_get_featured_image($post_ID);
  ?>
  <div class="postbox">


      <div class="inside" style="padding-bottom:20px;display: block;">

      <table width="100%">
      <tr><td>

      <span style="color:#183691;" ><code>[spartan_gallery  id="<code style="color:green;" ><?php print_r(get_the_ID()); ?></code>"]</code><code style="color:#A71D5D;" ></code>
   </span>
      </td>
      <td width="50px" style="align:right;">



       </td></tr>
       </table>

      </div>
  </div>


<?php
 }
}



############################
######### EXAMPLES #########
############################

// ADD A COLUMN TO ALL POST TYPES, EXCEPT PAGES

add_filter('manage_spartan_gallery_type_posts_columns', 'gallery_columns_head');
add_action('manage_spartan_gallery_type_posts_custom_column', 'gallery_columns_content', 10, 2);
//spartan_gallery_type

/*------------------------------------------------*/

// REMOVE DEFAULT CATEGORY COLUMN FROM WORDPRESS DEFAULT POSTS

add_filter('manage_post_posts_columns', 'gallery_columns_remove_category');

function gallery_columns_remove_category($defaults) {
 // to get defaults column names:
 // print_r($defaults);
 unset($defaults['categories']);
 return $defaults;
}


?>
