<?php

defined( 'ABSPATH' ) || exit;

if(!class_exists('BOOM_WP_FAQ_SCHEMA_ADMIN_INIT')) {
	class BOOM_WP_FAQ_SCHEMA_ADMIN_INIT {
		public function __construct(){
			add_action('add_meta_boxes', array( $this, 'boom_wp_faq_schema_add_custom_box' ) );
			add_action('save_post', array( $this, 'boom_wp_faq_schema_save_metadata') );
		}
		
		public function boom_wp_faq_schema_add_custom_box() {
			add_meta_box(
				'boom_wp_faq_schema_box_id', 					// Unique ID
				'WP FAQ Schema Markup', 						// Box title
				array($this, 'boom_wp_faq_schema_custom_box_html'),	// Content callback, must be of type callable
				array( 'post', 'page', 'bhc_page') 					// Post type
			);
		}
		
		public function boom_wp_faq_schema_custom_box_html($post) {
			// Variables
			$faq_script_status = false;
			$saved = get_post_meta($post->ID, 'faq_meta', true); // Get the saved values
			$faq_script_status = get_post_meta($post->ID, 'faq_script_status', true);
			$faqArray = [];
			if ($saved !== null) {
				$saved = str_replace("\'", "'", $saved);
				
				$defaults = json_decode($saved, true); // Get the default values
				foreach ($defaults as $item) {
					$faq = [
						'question' => stripslashes($item['question']),
						'answer' => stripslashes($item['answer'])
					];
					$faqArray[] = $faq;
				}
			}
			
			include( plugin_dir_path(__FILE__) . 'templates/faq-template.php' );
		}
		
		public function boom_wp_faq_schema_save_metadata($post_id) {
			if (!isset($_POST['boom_wp_faq_schema_form_metabox_process'])
				|| !wp_verify_nonce($_POST['boom_wp_faq_schema_form_metabox_process'], 'boom_wp_faq_schema_form_metabox_nonce')
				|| !current_user_can('edit_post', $post_id)) {
				return $post_id;
			}
			
			$allowed_html = $this->boom_wp_faq_schema_allowed_html_tags();
			
			$mainArray = [];
			if (isset($_POST['question']) && !empty($_POST['question'])) {
				foreach ($_POST['question'] as $key => $question) {
					if($question != "" || $question !== null){
						$answer = $_POST['answer'][$key];
						$answer = preg_replace('/\s+/S', " ", $answer);
						$question = preg_replace('/\s+/S', " ", $question);
						
						$faq = [
							"question" => addslashes(wp_kses($question,$allowed_html)),
							"answer" =>   addslashes(wp_kses($answer,$allowed_html)),
						];
						$mainArray[] = $faq;
					}
					
				}
			}
			
			$mainArray = json_encode($mainArray,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
			update_post_meta($post_id, 'faq_meta', $mainArray);
			
			if ($_POST['faq_script_status']) {
				update_post_meta($post_id, 'faq_script_status', true);
			} else {
				update_post_meta($post_id, 'faq_script_status', false);
			}
			
			do_action('faq_metadata_after_saved', [
				'post_id' => $post_id,
				'faq_meta' => $mainArray,
			]);
			
			return $post_id;
		}
		
		public function boom_wp_faq_schema_allowed_html_tags() {
			
			return [
				'a' => [
					'class' => [],
					'href'  => [],
					'rel'   => [],
					'title' => [],
				],
				'abbr' => [
					'title' => [],
				],
				'b' => [],
				'blockquote' => [
					'cite'  => [],
				],
				'cite' => [
					'title' => [],
				],
				'code' => [],
				'del' => [
					'datetime' => [],
					'title' => [],
				],
				'dd' => [],
				'div' => [
					'class' => [],
					'title' => [],
					'style' => [],
				],
				'dl' => [],
				'dt' => [],
				'em' => [],
				'h1' => [],
				'h2' => [],
				'h3' => [],
				'h4' => [],
				'h5' => [],
				'h6' => [],
				'i' => [],
				'img' => [
					'alt'    => [],
					'class'  => [],
					'height' => [],
					'src'    => [],
					'width'  => [],
				],
				'li' => [
					'class' => [],
				],
				'ol' => [
					'class' => [],
				],
				'p' => [
					'class' => [],
				],
				'q' => [
					'cite' => [],
					'title' => [],
				],
				'span' => [
					'class' => [],
					'title' => [],
					'style' => [],
				],
				'strike' => [],
				'strong' => [],
				'ul' => [
					'class' => [],
				],
			];
		}
	}
}