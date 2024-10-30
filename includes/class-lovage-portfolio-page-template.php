<?php
/**
 * Lovage Portfolio Plugin Page Templates
 *
 * @package Lovage Portfolio
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

if( ! class_exists( 'Lovage_Portfolio_Page_Templates' ) ) {

	class Lovage_Portfolio_Page_Templates extends Lovage_Plugin_Page_Templates_Loader {
		/**
		 * Page Template List
		 * @since 1.0.0
		 */
		public $page_templates = array(
			'lovage-portfolio-grid-page-template' => 'Portfolio Grid Template'
		);

		/**
		 * Page Template Folder Path
		 * @since 1.0.0
		 */
		public $page_template_dir = LPT_DIR . '/templates/';
	}

}

return new Lovage_Portfolio_Page_Templates();