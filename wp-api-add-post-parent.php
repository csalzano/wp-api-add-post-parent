<?php
/**
 * Plugin Name: Add Post Parent to WP API
 * Plugin URI: https://github.com/csalzano/wp-api-add-post-parent
 * Description: Add a field `parent` to the /v2/posts and /v2/media routes of the WP API
 * Version: 1.0.1
 * Author: Corey Salzano
 * Author URI: https://profiles.wordpress.org/salzano
 * Text Domain: wp-api-add-post-parent
 * Domain Path: /languages
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

class WP_API_Add_Post_Parent{

	function hooks() {
		add_action( 'rest_api_init', array( $this, 'add_post_parent_to_posts_route' ) );
	}

	function add_post_parent_to_posts_route() {
		$args = array(
			'get_callback'    => array( $this, 'get_post_parent' ),
			'update_callback' => array( $this, 'set_post_parent' ),
			'schema'          => null,
		);
		register_rest_field( 'post', 'parent', $args );
		register_rest_field( 'attachment', 'parent', $args );
	}

	function get_post_parent( $data ) {
		$post = get_post( $data['id'] );
		return $post->post_parent;
	}

	function set_post_parent( $value, $post, $attr, $request, $object_type ) {
		//permission to edit built-in post types is handled for us
		wp_update_post(
			array(
				'ID'          => $post->ID,
				'post_parent' => $value,
			)
		);
	}
}
$add_post_parent_2934870234723 = new WP_API_Add_Post_Parent();
$add_post_parent_2934870234723->hooks();
