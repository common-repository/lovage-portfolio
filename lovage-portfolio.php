<?php
/**
 * Plugin Name: Lovage Portfolio
 * Plugin URI: https://lovage.io/product/lovage-portfolio
 * Description: Lovage Portfolio offer the portfolio custom post type and the other basic features that allows you to show your projects on your WordPress site.
 * Version: 1.0.3
 * Author: Lovage
 * Author URI: https://lovage.io
 * Text Domain: lovage-portfolio
 * Domain Path: /languages/
 *
 * @package Lovage Portfolio
 */

defined( 'ABSPATH' ) || exit;


// Define LOVAGE_PORTFOLIO_FILE.
if ( ! defined( 'LOVAGE_PORTFOLIO_FILE' ) ) {
	define( 'LOVAGE_PORTFOLIO_FILE', __FILE__ );
}

// Include the main Lovage Pro class.
if ( ! class_exists( 'Lovage_Portfolio' ) ) {
	include_once dirname( __FILE__ ) . '/includes/class-lovage-portfolio.php';
}

/**
 * Returns the main instance of Lovage_Portfolio.
 *
 * @since  1.0
 * @return Lovage_Portfolio
 */
function Lovage_Portfolio() { 
	return Lovage_Portfolio::instance();
}

// Global for backwards compatibility.
$GLOBALS['Lovage_Portfolio'] = Lovage_Portfolio();

// Set the slug for the post type and taxonomy.
Lovage_Portfolio()->settings( 'portfolio', 'portfolio-type' );
