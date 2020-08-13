<?php
/*
 * Plugin Name: WP FAQ Schema Markup for SEO
 * Description: Get FAQ Structured Data in Google SERP
 * Version: 2.0
 * Author: Team HobCore / Boom Online Marketing
 * Text Domain: boom_wp_faq_schema
 * License: GPLv2
 */

defined( 'ABSPATH' ) || exit;

define('BOOM_WP_FAQ_SCHEMA_PLUGIN_URL', __FILE__);

if(!class_exists('BOOM_WP_FAQ_SCHEMA')){
	class BOOM_WP_FAQ_SCHEMA {
		public function __construct(){
			
			require_once plugin_dir_path(__FILE__) . 'includes/init.php';
			require_once plugin_dir_path(__FILE__) . 'includes/admin/init.php';
			require_once plugin_dir_path(__FILE__) . 'includes/admin/enqueue.php';
			
			$BOOM_WP_FAQ_SCHEMA_INIT = new BOOM_WP_FAQ_SCHEMA_INIT();
			$BOOM_WP_FAQ_SCHEMA_ADMIN_INIT = new BOOM_WP_FAQ_SCHEMA_ADMIN_INIT();
			$BOOM_WP_FAQ_SCHEMA_ENQUEUES = new BOOM_WP_FAQ_SCHEMA_ENQUEUES();
		}
	}
	$BOOM_WP_FAQ_SCHEMA = new BOOM_WP_FAQ_SCHEMA();
}
