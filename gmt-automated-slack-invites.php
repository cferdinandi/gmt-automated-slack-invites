<?php

/**
 * Plugin Name: GMT Automated Slack Invites
 * Plugin URI: https://github.com/cferdinandi/gmt-automated-slack-invites/
 * GitHub Plugin URI: https://github.com/cferdinandi/gmt-automated-slack-invites/
 * Description: Automate Slack team invites with WordPress.
 * Version: 1.2.0
 * Author: Chris Ferdinandi
 * Author URI: http://gomakethings.com
 * License: GPLv3
 */


// Define constants
define( 'GMT_AUTOMATED_SLACK_INVITES_VERSION', '1.2.0' );


// Load includes
if ( !class_exists( 'Slack_Invite' ) ) {
	require_once( plugin_dir_path( __FILE__ ) . 'includes/slack-api.php' );
}
require_once( plugin_dir_path( __FILE__ ) . 'includes/wp-session-manager/wp-session-manager.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/helpers.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/options.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/form.php' );


/**
 * Check the plugin version and make updates if needed
 */
function gmt_edd_slack_check_version() {

	// Get plugin data
	$old_version = get_site_option( 'gmt_edd_slack_version' );

	// Update plugin to current version number
	if ( empty( $old_version ) || version_compare( $old_version, GMT_AUTOMATED_SLACK_INVITES_VERSION, '<' ) ) {
		update_site_option( 'gmt_edd_slack_version', GMT_AUTOMATED_SLACK_INVITES_VERSION );
	}

}
add_action( 'plugins_loaded', 'gmt_edd_slack_check_version' );



function gmt_edd_slack_set_submit_string() {

	if ( empty( get_site_option( 'gmt_edd_slack_submit_hash' ) ) ) {
		update_site_option( 'gmt_edd_slack_submit_hash', wp_generate_password( 24, false ) );
	}

}
add_action( 'plugins_loaded', 'gmt_edd_slack_set_submit_string' );