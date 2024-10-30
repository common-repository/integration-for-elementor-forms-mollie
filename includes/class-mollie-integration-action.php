<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit; 
}

class Mollie_Integration_Action_After_Submit extends \ElementorPro\Modules\Forms\Classes\Action_Base {

	/**
	 * Get Name
	 *
	 * Return the action name
	 *
	 * @access public
	 * @return string
	 */
	public function get_name() {
		return 'mollie integration';
	}

	/**
	 * Get Label
	 *
	 * Returns the action label
	 *
	 * @access public
	 * @return string
	 */
	public function get_label() {
		return __( 'Mollie', 'mollie-elementor-integration' );
	}

	/**
	 * Register Settings Section
	 *
	 * Registers the Action controls
	 *
	 * @access public
	 * @param \Elementor\Widget_Base $widget
	 */
	public function register_settings_section( $widget ) {
		$widget->start_controls_section(
			'section_mollie-elementor-integration',
			[
				'label' => __( 'Mollie', 'mollie-elementor-integration' ),
				'condition' => [
					'submit_actions' => $this->get_name(),
				],
			]
		);

		$widget->add_control(
			'mollie_api_key',
			[
				'label' => __( 'Mollie API Key', 'mollie-elementor-integration' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => 'APIKEY',
				'label_block' => true,
				'separator' => 'before',
				'description' => __( 'Enter your mollie API key', 'mollie-elementor-integration' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$widget->add_control(
			'mollie_redirect_url',
			[
				'label' => __( 'Mollie Redirect URL', 'mollie-elementor-integration' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => 'https://website.com/thank-you',
				'label_block' => true,
				'separator' => 'before',
				'description' => __( 'Enter the url you want to redirect to after the user paid', 'mollie-elementor-integration' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$widget->add_control(
			'mollie_webhook_url',
			[
				'label' => __( 'Mollie Webhook URL', 'mollie-elementor-integration' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => 'https://website.com/mywebhook',
				'label_block' => true,
				'description' => __( 'Enter the url you want to send data to after the user paid', 'mollie-elementor-integration' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$widget->add_control(
			'mollie_payment_dynamic_pricing_switcher',
			[
				'label' => __( 'Dynamic pricing', 'mollie-elementor-integration' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'separator' => 'before'
			]
		);

		$widget->add_control(
			'mollie_payment_amount',
			[
				'label' => __( 'Payment Amount', 'mollie-elementor-integration' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'placeholder' => '10',
				'label_block' => true,
				'separator' => 'before',
				'description' => __( 'Enter the amount the client needs to pay', 'mollie-elementor-integration' ),
				'condition' => array(
    				'mollie_payment_dynamic_pricing_switcher!' => 'yes',
    			),
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$widget->add_control(
			'mollie_payment_dynamic_field_id',
			[
				'label' => __( 'Payment Amount', 'mollie-elementor-integration' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => 'pricingvaluefieldid',
				'separator' => 'before',
				'description' => __( 'Enter the dynamic pricing field id this will use the value after the pipe symbol - you can find this under the fields advanced tab', 'mollie-elementor-integration' ),
				'condition' => array(
    				'mollie_payment_dynamic_pricing_switcher' => 'yes',
    			),
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$widget->add_control(
			'mollie_payment_description',
			[
				'label' => __( 'Payment Description', 'mollie-elementor-integration' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => 'This is a description',
				'label_block' => true,
				'separator' => 'before',
				'description' => __( 'Enter the payment description', 'mollie-elementor-integration' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$widget->add_control(
			'mollie_payment_currency',
			[
				'label' => __( 'Payment Currency', 'mollie-elementor-integration' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'solid',
				'options' => [
					'EUR'  => __( 'EUR', 'mollie-elementor-integration' ),
					'GBP' => __( 'GBP', 'mollie-elementor-integration' ),
					'USD' => __( 'USD', 'mollie-elementor-integration' ),
				],
				'label_block' => true,
				'separator' => 'before',
				'description' => __( 'Enter the payment currency', 'mollie-elementor-integration' ),
			]
		);

		//Create metadatarepeater
		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'mollie_custom_metadata_name', [
				'label' => __( 'Metadata name', 'mollie-elementor-integration' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'metadata name' , 'mollie-elementor-integration' ),
				'label_block' => true,
				'description' => __( 'Enter the metadata name', 'mollie-elementor-integration' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$repeater->add_control(
			'mollie_custom_metadata_value', [
				'label' => __( 'Metadata value', 'mollie-elementor-integration' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'metadata value' , 'mollie-elementor-integration' ),
				'label_block' => true,
				'description' => __( 'Enter the metadata value', 'mollie-elementor-integration' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$widget->add_control(
			'mollie_custom_metadata_list',
			[
				'label' => __( 'Mollie Metadata Mapping', 'mollie-elementor-integration' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'separator' => 'before',
				'default' => [
					[
						'mollie_custom_metadata_name' => __( 'clientname', 'mollie-elementor-integration' ),
						'mollie_custom_metadata_value' => __( 'john', 'mollie-elementor-integration' ),
					],
					[
						'mollie_custom_metadata_name' => __( 'clientlastname', 'mollie-elementor-integration' ),
						'mollie_custom_metadata_value' => __( 'doe', 'mollie-elementor-integration' ),
					],
				],
				'title_field' => '{{{ mollie_custom_metadata_name }}}',
			]
		);

		$widget->end_controls_section();

	}

	/**
	 * On Export
	 *
	 * Clears form settings on export
	 * @access Public
	 * @param array $element
	 */
	public function on_export( $element ) {
		unset(
			$element['mollie_api_key'],
			$element['mollie_redirect_url'],
			$element['mollie_webhook_url'],
			$element['mollie_payment_dynamic_pricing_switcher'],
			$element['mollie_payment_dynamic_field_id'],
			$element['mollie_payment_amount'],
			$element['mollie_payment_description'],
			$element['mollie_payment_currency'],
			$element['mollie_custom_metadata_name'],
			$element['mollie_custom_metadata_value']
		);

		return $element;
	}

	/**
	 * Run
	 *
	 * Runs the action after submit
	 *
	 * @access public
	 * @param \ElementorPro\Modules\Forms\Classes\Form_Record $record
	 * @param \ElementorPro\Modules\Forms\Classes\Ajax_Handler $ajax_handler
	 */
	public function run( $record, $ajax_handler ) {
		$settings = $record->get( 'form_settings' );

		// Get submitted Form data
		$raw_fields = $record->get( 'fields' );

		// Normalize the Form Data
		$fields = [];
		foreach ( $raw_fields as $id => $field ) {
			$fields[ $id ] = $field['value'];
		}

		// Process custom metadata mapping
		$metadatasettings = $settings['mollie_custom_metadata_list'];
		$metadata = array();
		foreach ($metadatasettings as $metadatasetting) {
			$metadataname = $metadatasetting['mollie_custom_metadata_name'];
			$metadatavalue = $metadatasetting['mollie_custom_metadata_value'];
			$valuetosend = $fields[$metadatavalue];
			$metadata[$metadataname] = $valuetosend;
		}

		//Create mollie payment here
		$mollie = new \Mollie\Api\MollieApiClient();
		$mollie->setApiKey($settings['mollie_api_key']);

		$dynamicprice = $settings['mollie_payment_dynamic_pricing_switcher'];

		if ($dynamicprice == "yes") {
			$paymentvalue = number_format((float)$fields[$settings['mollie_payment_dynamic_field_id']], 2, '.', '');
		} else {
			$paymentvalue = number_format((float)$settings['mollie_payment_amount'], 2, '.', '');
		}

		$payment = $mollie->payments->create([
			"amount" => [
				"currency" => $settings['mollie_payment_currency'],
				"value" => $paymentvalue
			],
			"description" => $settings['mollie_payment_description'],
			"redirectUrl" => $settings['mollie_redirect_url'],
			"webhookUrl"  => $settings['mollie_webhook_url'],
			"metadata" => $metadata,
		]);
		//Redirect
		$redirect_to = $payment->getCheckoutUrl();
		$ajax_handler->add_response_data( 'redirect_url', $redirect_to );

	}
}