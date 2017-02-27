<?php

/**
 * Plugin Name: GMT Automated Slack Invites
 * Plugin URI: https://github.com/cferdinandi/gmt-automated-slack-invites/
 * GitHub Plugin URI: https://github.com/cferdinandi/gmt-automated-slack-invites/
 * Description: Automate Slack team invites with WordPress.
 * Version: 1.0.0
 * Author: Chris Ferdinandi
 * Author URI: http://gomakethings.com
 * License: GPLv3
 */


// Load includes
if ( !class_exists( 'Slack_Invite' ) ) {
	require_once( plugin_dir_path( __FILE__ ) . 'includes/slack-api.php' );
}
require_once( plugin_dir_path( __FILE__ ) . 'includes/wp-session-manager/wp-session-manager.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/helpers.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/options.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/form.php' );