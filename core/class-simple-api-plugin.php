<?php
class Simple_API_Plugin {

	public static function init() {
		
	}
	
	// GET
	public static function get( $url ) {
	    
	    // With authentication
	    /*
	    $args = array(
	        'headers' => array(
	            'Authorization' => 'Basic ' . base64_encode( YOUR_USERNAME . ':' . YOUR_PASSWORD )
	        )
	    );
	    wp_remote_get( $url, $args );
	    */
	    
	    $response = wp_remote_get( $url );
	    if( is_wp_error( $response ) ) {
	        return false;
	    }
	    $http_code = wp_remote_retrieve_response_code( $response );
	    if ( $http_code != '200' ) {
	        return false;
	    }
	    
	    $body = wp_remote_retrieve_body( $response );
	    
	    return $body;
	}
	
	/**
	 * 
	 * @param string $url
	 * @param array $data
	 */
	public static function post( $url, $data ) {
	    $response = wp_remote_post( $url, array(
	        'body'    => $data,
	        'headers' => array(
	            'Authorization' => 'Basic ' . base64_encode( $username . ':' . $password ),
	        ),
	    ) );
	    return $response;
	}
	
}
Simple_API_Plugin::init();
