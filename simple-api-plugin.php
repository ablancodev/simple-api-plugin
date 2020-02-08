<?php
/**
 * simple-api-plugin.php
 *
 * Copyright (c) 2011,2017 Antonio Blanco http://www.ablancodev.com
 *
 * This code is released under the GNU General Public License.
 * See COPYRIGHT.txt and LICENSE.txt.
 *
 * This code is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * This header and all notices must be kept intact.
 *
 * @author Antonio Blanco
 * @package simple-api-plugin
 * @since simple-api-plugin 1.0.0
 *
 * Plugin Name: Simple Plugin
 * Plugin URI: http://www.ablancodev.com
 * Description: Simple API plugin skeletor.
 * Version: 1.0.0
 * Author: ablancodev
 * Author URI: http://www.ablancodev.com
 * Text Domain: simple-api-plugin
 * Domain Path: /languages
 * License: GPLv3
 */
if (! defined ( 'SIMPLE_API_PLUGIN_CORE_DIR' )) {
	define ( 'SIMPLE_API_PLUGIN_CORE_DIR', WP_PLUGIN_DIR . '/simple-api-plugin' );
}
define ( 'SIMPLE_API_PLUGIN_FILE', __FILE__ );

define ( 'SIMPLE_API_PLUGIN_PLUGIN_URL', plugin_dir_url ( SIMPLE_API_PLUGIN_FILE ) );

class SimpleAPIPplugin_Plugin {

	public static $notices = array ();


	public static function init() {
		add_action ( 'init', array (
				__CLASS__,
				'wp_init' 
		) );
		add_action ( 'admin_notices', array (
				__CLASS__,
				'admin_notices' 
		) );

		add_action('admin_init', array ( __CLASS__, 'admin_init' ) );

		register_activation_hook( SIMPLE_API_PLUGIN_FILE, array( __CLASS__, 'activate' ) );

	}
	public static function wp_init() {
		load_plugin_textdomain ( 'simple-api-plugin', null, 'simple-api-plugin/languages' );

		add_action ( 'admin_menu', array (
				__CLASS__,
				'admin_menu' 
		), 40 );

		require_once 'core/class-simple-api-plugin.php';

		// styles & javascript
		add_action ( 'admin_enqueue_scripts', array (
				__CLASS__,
				'admin_enqueue_scripts' 
		) );
	}

	public static function admin_init() {

	}


	public static function admin_enqueue_scripts($page) {
		// css
		wp_register_style ( 'simple-api-plugin-admin-style', SIMPLE_API_PLUGIN_PLUGIN_URL . '/css/admin-style.css', array (), '1.0.0' );
		wp_enqueue_style ( 'simple-api-plugin-admin-style' );

		// Our javascript
		wp_register_script ( 'simple-api-plugin-admin-scripts', SIMPLE_API_PLUGIN_PLUGIN_URL . '/js/admin-scripts.js', array ( 'jquery' ), '1.0.0', true );
		wp_enqueue_script ( 'simple-api-plugin-admin-scripts' );

	}

	public static function admin_notices() {
		if (! empty ( self::$notices )) {
			foreach ( self::$notices as $notice ) {
				echo $notice;
			}
		}
	}

	/**
	 * Adds the admin section.
	 */
	public static function admin_menu() {
		$admin_page = add_menu_page (
				__ ( 'Simple API Plugin', 'simple-api-plugin' ),
				__ ( 'Simple API Plugin', 'simple-api-plugin' ),
				'manage_options', 'simple-api-plugin',
				array (
					__CLASS__,
					'simple_api_plugin_menu_settings' 
				),
				SIMPLE_API_PLUGIN_PLUGIN_URL . '/images/settings.png' );
	}

	public static function simple_api_plugin_menu_settings() {
		// if submit
		if ( isset( $_POST ["simple_api_plugin_settings"] ) && wp_verify_nonce ( $_POST ["simple_api_plugin_settings"], "simple_api_plugin_settings" ) ) {
			// name
			update_option ( "simple_api_plugin_url_get", sanitize_text_field ( $_POST ["simple_api_plugin_url_get"] ) );
		}
		?>
		<h2><?php echo __( 'Simple Plugin', 'simple-api-plugin' ); ?></h2>

		<form method="post" action="" enctype="multipart/form-data" >
			<div class="">
				<p>
					<label><?php echo __( "URL GET", 'simple-api-plugin' );?></label> <input
						type="text" name="simple_api_plugin_url_get"
						value="<?php echo get_option( "simple_api_plugin_url_get" ); ?>" />
				</p>
				<?php
				wp_nonce_field ( 'simple_api_plugin_settings', 'simple_api_plugin_settings' )?>
					<input type="submit"
					value="<?php echo __( "Save", 'simple-api-plugin' );?>"
					class="button button-primary button-large" />
			</div>
		</form>
		<?php 
	}

	/**
	 * Plugin activation work.
	 *
	 */
	public static function activate() {
	}
}
SimpleAPIPplugin_Plugin::init();
