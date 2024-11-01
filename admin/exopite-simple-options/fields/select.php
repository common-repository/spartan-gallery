<?php if ( ! defined( 'ABSPATH' ) ) {
	die;
}
if ( ! class_exists( 'Exopite_Simple_Options_Framework_Field_select' ) ) {

	class Exopite_Simple_Options_Framework_Field_select extends Exopite_Simple_Options_Framework_Fields {

		public function __construct( $field, $value = '', $unique = '', $config = array() ) {
			parent::__construct( $field, $value, $unique, $config );
		}

		public function output() {

			echo $this->element_before();

			if ( isset( $this->field['options'] ) || isset( $this->field['query'] ) ) {

				$options    = ( isset( $this->field['options'] ) && is_array( $this->field['options'] ) ) ? $this->field['options'] : array();
				$query      = ( isset( $this->field['query'] ) && isset( $this->field['query']['type'] ) ) ? $this->field['query'] : false;
				$select     = ( $query ) ? $this->element_data( $query['type'] ) : $options;
				$class      = $this->element_class();
				$extra_name = ( isset( $this->field['attributes']['multiple'] ) ) ? '[]' : '';

				echo '<select name="' . $this->element_name( $extra_name ) . '"' . $this->element_class() . $this->element_attributes() . '>';

				echo ( isset( $this->field['default_option'] ) ) ? '<option value="">' . $this->field['default_option'] . '</option>' : '';

				if ( ! empty( $select ) ) {

					foreach ( $select as $key => $value ) {
						echo '<option value="' . $key . '" ' . $this->checked( $this->element_value(), $key, 'selected' ) . '>' . $value . '</option>';

					}
				}

				echo '</select>';

			}

			echo $this->element_after();

		}

		/**
		 * Populate select from wp_query
		 */
		public function element_data( $type = '' ) {

			$select     = array();
			$query      = ( isset( $this->field['query'] ) ) ? $this->field['query'] : array();
			$query_args = array();

			/**
			 * Make possible to have different args for different pages.
			 */
			if ( isset( $query['args'] ) && is_array( $query['args'] ) ) {

				// Check if multi_query is set
				if ( isset( $query['args']['multi_query'] ) && true === $query['args']['multi_query'] ) {

					foreach ( $query['args'] as $args ) {

						// Skip if not an array (eg. 'multi_query' => true )
						if ( ! is_array( $args ) ) {
							continue;
						}
						global $post;
						$display_on = $args['display_on'];

						// 'disply_on' is the post slog or id
						if ( ( is_array( $display_on ) && in_array( $post->post_name, $display_on ) ) ||
						     ( ! is_array( $display_on ) && $display_on == $post->post_name ) ||
						     ( is_array( $display_on ) && in_array( $post->ID, $display_on ) ) ||
						     ( ! is_array( $display_on ) && $display_on == $post->ID )
						) {

							// remove 'display_on'
							unset( $args['display_on'] );
							// set args
							$query_args = $args;
						}

					}

				} else {
					$query_args = $query['args'];
				}

			}

			switch ( $type ) {

				case 'pages':
				case 'page':

					$pages = get_pages( $query_args );

					if ( ! is_wp_error( $pages ) && ! empty( $pages ) ) {
						foreach ( $pages as $page ) {
							$select[ $page->ID ] = $page->post_title;
						}
					}

					break;

				case 'posts':
				case 'post':

					$posts = get_posts( $query_args );

					if ( ! is_wp_error( $posts ) && ! empty( $posts ) ) {
						foreach ( $posts as $post ) {
							$select[ $post->ID ] = $post->post_title;
						}
					}

					break;

				case 'categories':
				case 'category':

					$categories = get_categories( $query_args );

					if ( ! is_wp_error( $categories ) && ! empty( $categories ) && ! isset( $categories['errors'] ) ) {
						foreach ( $categories as $category ) {
							$select[ $category->term_id ] = $category->name;
						}
					}

					break;

				case 'tags':
				case 'tag':

					$taxonomies = ( isset( $query_args['taxonomies'] ) ) ? $query_args['taxonomies'] : 'post_tag';
					$tags       = get_terms( $taxonomies, $query_args );

					if ( ! is_wp_error( $tags ) && ! empty( $tags ) ) {
						foreach ( $tags as $tag ) {
							$select[ $tag->term_id ] = $tag->name;
						}
					}

					break;

				case 'menus':
				case 'menu':

					$menus = wp_get_nav_menus( $query_args );

					if ( ! is_wp_error( $menus ) && ! empty( $menus ) ) {
						foreach ( $menus as $menu ) {
							$select[ $menu->term_id ] = $menu->name;
						}
					}

					break;

				case 'post_types':
				case 'post_type':

					$query_args['show_in_nav_menus'] = true;
					$post_types                      = get_post_types( $query_args );

					if ( ! is_wp_error( $post_types ) && ! empty( $post_types ) ) {
						foreach ( $post_types as $post_type ) {
							$select[ $post_type ] = ucfirst( $post_type );
						}
					}

					break;

				case 'users':
				case 'user':

					$users = get_users( $query_args );

					/**
					 * key:   the name in select
					 * value: the value in select
					 */
					$key   = ( isset ( $this->field['query']['key'] ) ) ? sanitize_key( $this->field['query']['key'] ) : 'ID';
					$value = ( isset ( $this->field['query']['value'] ) ) ? sanitize_key( $this->field['query']['value'] ) : 'user_login';

					if ( ! is_wp_error( $users ) && ! empty( $users ) ) {
						foreach ( $users as $user ) {
							$select[ $user->{$key} ] = $user->{$value};
						}
					}

					break;

				case 'custom':
				case 'callback':

					/**
					 * Get post object if it is a metabox and not yet set.
					 * Then send post object to callback function.
					 */
					if ( isset( $this->config['type'] ) && $this->config['type'] == 'metabox' && ! isset( $post ) ) {
						global $post;
					} elseif ( isset( $this->config['type'] ) && $this->config['type'] == 'menu' ) {
						$post = array();
					}

					if ( is_callable( $query['function'] ) ) {
						$select = call_user_func( $query['function'], $query_args, $post );
					}

					break;

			}

			return $select;
		}




	}

}
