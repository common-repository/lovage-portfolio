<?php
/**
 * Lovage Portfolio MetaBox
 *
 * @package Lovage Portfolio
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

if( ! function_exists( 'lovage_portfolio_metabox' ) ) {
	function lovage_portfolio_metabox(){

		$portfolio_settings = new Lovage_MetaBox();

		$prefix = '_lovage_portfolio_';

		$portfolio_settings->metabox = array(
		   'id'    		  => 'lovage_portfolio_metabox',
		   'title' 		  => esc_html__('Project Settings', 'lovage-portfolio'),
		   'description'  => esc_html__('The settings for this project.', 'lovage-portfolio'),
		   'context'	  => 'normal',
		   'post_type'	  => array( 'lovage-portfolio' ),
		   'tabs'		  => apply_filters( 'lovage_portfolio_metabox_tabs', array(
		      'project_info' => array(
				      				'title'    => esc_html__( 'Project Information', 'lovage-portfolio' ),
				      			  ),
		      'project_media' => array(
				      				'title'    => esc_html__( 'Upload Media Files', 'lovage-portfolio' ),
				      			  ),
		   ) ),
		   'options'  => apply_filters( 'lovage_portfolio_metabox_options', array(
		   	   
			   $prefix.'client_name' => array(
					'label'			 => esc_html( 'Client', 'lovage-portfolio' ),
					'tab'			 => 'project_info',
					'type'			 => 'text',
					'default'		 => ''
			   ),

			   $prefix.'project_url' => array(
					'label'			 => esc_html( 'Project URL ', 'lovage-portfolio' ),
					'placeholder'	 => esc_html__( 'Don\'t forget http:// or https://', 'lovage-portfolio' ),
					'tab'			 => 'project_info',
					'type'			 => 'url',
					'default'		 => ''
			   ),

			   $prefix.'skills_needed' => array(
					'label'			 => esc_html( 'Skills Needed', 'lovage-portfolio' ),
					'tab'			 => 'project_info',
					'type'			 => 'text',
					'default'		 => '',
			   ),

			   $prefix.'finish_date' => array(
					'label'			 => esc_html( 'Finish Date', 'lovage-portfolio' ),
					'placeholder'	 => esc_html__( 'Pick a date', 'lovage-portfolio' ),
					'tab'			 => 'project_info',
					'type'			 => 'date-picker',
					'default'		 => '',
			   ),

			   $prefix.'images' => array(
					'label'			 => esc_html( 'Upload Images', 'lovage-portfolio' ),
					'tab'			 => 'project_media',
					'type'			 => 'multi-image',
					'default'		 => '',
			   ),

		   ) )
		);
	}
}
add_action( 'init', 'lovage_portfolio_metabox' );