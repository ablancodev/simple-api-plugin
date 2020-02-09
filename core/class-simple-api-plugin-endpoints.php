<?php
class Simple_API_Plugin_Endpoints {

	public static function init() {
	    add_action( 'rest_api_init', array( __CLASS__, 'register_endpoints' ) );
	}
	
	public static function register_endpoints() {
	    register_rest_route( 'my_api_namespace/v1', '/foo', array(
	        'methods' => WP_REST_Server::READABLE,
	        'callback' => array( __CLASS__, 'get_foo' ),
	    ) );
	    register_rest_route( 'my_api_namespace/v1', '/foo', array(
	        'methods' => WP_REST_Server::CREATABLE,
	        'callback' => array( __CLASS__, 'create_foo' ),
	    ) );
	}
	
	public static function get_foo( $request ) {
	    $data = get_posts( array(
	        'post_type'      => 'foo',
	        'post_status'    => 'publish',
	        'posts_per_page' => 20,
	    ) );
	    
	    return new WP_REST_Response( $data, 200 );
	}
	
	public static function create_foo( $request ) {
	    $params = $request->get_body_params();
	    
	    $post_id = wp_insert_post( array(
	        'post_title'    => isset( $params['name']    ) ? $params['name'] : 'Untitled Foo',
	        'post_content'  => isset( $params['details'] ) ? $params['details'] : '',
	        'post_type'     => 'foo',
	        'post_status'   => 'publish',
	    ) );
	    
	    return new WP_REST_Response( $post_id, 200 );
	}
}
Simple_API_Plugin_Endpoints::init();