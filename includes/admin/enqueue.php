<?php

defined( 'ABSPATH' ) || exit;

if(!class_exists('BOOM_WP_FAQ_SCHEMA_ENQUEUES')) {
	class BOOM_WP_FAQ_SCHEMA_ENQUEUES {
		public function __construct(){
			add_action( 'admin_enqueue_scripts', array( $this, 'boom_wp_faq_schema_enqueue_admin_scripts') );
		}
		
		public function boom_wp_faq_schema_enqueue_admin_scripts(){
			wp_enqueue_style( 'boom_wp_faq_schema_admin_style', plugins_url( '/assets/css/admin-style.css', BOOM_WP_FAQ_SCHEMA_PLUGIN_URL ) );
			
			wp_enqueue_script(
				'boom_wp_faq_schema_admin_global_js', plugins_url( '/assets/js/admin-global.js', BOOM_WP_FAQ_SCHEMA_PLUGIN_URL ), ['jquery'], '1.0.0', true
			);
			wp_localize_script( 'boom_wp_faq_schema_admin_global_js', 'faq_obj', [
				'ajax_url' => admin_url( 'admin-ajax.php' )
			]);
		}
	}
}