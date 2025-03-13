<?php
/**
 * Plugin Name:       Gravity Forms Phone Validation
 * Description:       A simple plugin to add phone validation to Gravity Forms.
 * Requires at least: 6.5
 * Requires PHP:      8.1
 * Version:           0.0.0-development
 * Author:            CloudCatch LLC
 * Author URI:        https://cloudcatch.io
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       gf-phone-validation
 *
 * @package           GravityFormsPhoneValidation
 */

namespace CloudCatch\GravityFormsPhoneValidation;

use Exception;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/vendor/autoload.php';

/**
 * Validate the phone number field
 *
 * @param array $validation_result Contains the validation result and the current Form Object.
 *
 * @throws Exception If the phone number is invalid.
 *
 * @return array
 */
function validate_phone_number( $validation_result ) {
	$form = $validation_result['form'];

	$phone_util = \libphonenumber\PhoneNumberUtil::getInstance();

	foreach ( $form['fields'] as &$field ) {
		if ( 'phone' === $field->type ) {
			$submitted_value = \rgpost( "input_{$field->id}" );

			try {
				$phone_proto = $phone_util->parse( $submitted_value, get_option( 'gform_phone_validation_region', 'US' ) );

				if ( ! $phone_util->isValidNumber( $phone_proto ) ) {
					throw new Exception( esc_html__( 'Phone number must be a valid phone number.', 'gf-phone-validation' ) );
				}
			} catch ( Exception $e ) {
				$validation_result['is_valid'] = false;
				$field->failed_validation      = true;
				$field->validation_message     = esc_html( $e->getMessage() );
			}
		}
	}

	$validation_result['form'] = $form;

	return $validation_result;
}
add_filter( 'gform_validation', __NAMESPACE__ . '\validate_phone_number', PHP_INT_MAX );

/**
 * Add the phone validation region setting to the Gravity Forms settings page.
 *
 * @param array $fields The plugin settings fields.
 * @return array
 */
function add_settings_fields( $fields ) {
	$phone_util        = \libphonenumber\PhoneNumberUtil::getInstance();
	$available_regions = $phone_util->getSupportedRegions();

	$default_value = get_option( 'gform_phone_validation_region', 'US' );

	$choices = array_reduce(
		$available_regions,
		function ( $carry, $region ) use ( $default_value ) {
			$carry[] = array(
				'label'   => $region,
				'value'   => $region,
				'default' => $region === $default_value,
			);

			return $carry;
		},
		array()
	);

	/**
	 * Filter the main settings fields for the plugin.
	 */
	$fields['phone_validation_region'] = array(
		'id'          => 'phone_validation_region',
		'title'       => esc_html__( 'Phone Validation Region', 'gf-phone-validation' ),
		'description' => esc_html__( 'The default region code to use for phone number validation.', 'gf-phone-validation' ),
		'class'       => 'gform-settings-panel--half',
		'fields'      => array(
			array(
				'name'          => 'phone_validation_region',
				'type'          => 'select',
				'choices'       => $choices,
				'save_callback' => function ( $field, $value ) {
					update_option( 'gform_phone_validation_region', $value );

					return $value;
				},
			),
		),
	);

	return $fields;
}
add_filter( 'gform_plugin_settings_fields', __NAMESPACE__ . '\add_settings_fields' );
