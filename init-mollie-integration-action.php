<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit; 
}

add_action( 'elementor_pro/init', function() {
	// Here its safe to include our action class file
	include_once( dirname(__FILE__).'/includes/class-mollie-integration-action.php' );

	// Instantiate the action class
	$mollie_integration_action = new Mollie_Integration_Action_After_Submit();

	// Register the action with form widget
	\ElementorPro\Plugin::instance()->modules_manager->get_modules( 'forms' )->add_form_action( $mollie_integration_action->get_name(), $mollie_integration_action );
});