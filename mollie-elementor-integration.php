<?php

/**
 * Plugin Name: Integration for Elementor forms - Mollie
 * Description: Easily create payments with Mollie after an elementor form submission.
 * Author: Webtica
 * Author URI: https://webtica.be/
 * Version: 1.3.5
 * Elementor tested up to: 3.24.7
 * Elementor Pro tested up to: 3.24.4
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit; 
}

//load plugins functionallity
require dirname(__FILE__).'/init-mollie-integration-action.php';
require dirname(__FILE__).'/includes/settings.php';

//Load mollie libary
require_once(plugin_dir_path(__FILE__) . '/vendor/autoload.php');

//Check if Elementor pro is installed
function mollie_integration_check_elementor_pro_is_active() {

	if ( !is_plugin_active('elementor-pro/elementor-pro.php') ) {
		echo "<div class='error'><p><strong>Mollie for elementor forms</strong> requires <strong> Elementor Pro plugin to be installed and activated</strong> </p></div>";
	}
}
add_action('admin_notices', 'mollie_integration_check_elementor_pro_is_active');