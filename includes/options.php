<?php

/**
 * Theme Options v1.1.0
 * Adjust theme settings from the admin dashboard.
 * Find and replace `gmt_edd_slack` with your own namepspacing.
 *
 * Created by Michael Fields.
 * https://gist.github.com/mfields/4678999
 *
 * Forked by Chris Ferdinandi
 * http://gomakethings.com
 *
 * Free to use under the MIT License.
 * http://gomakethings.com/mit/
 */


	/**
	 * Theme Options Fields
	 * Each option field requires its own uniquely named function. Select options and radio buttons also require an additional uniquely named function with an array of option choices.
	 */

	function gmt_edd_slack_settings_field_domain_name() {
		$options = gmt_edd_slack_get_theme_options();
		?>
		<input type="text" name="gmt_edd_slack_theme_options[domain_name]" class="large-text" id="domain_name" value="<?php echo esc_attr( $options['domain_name'] ); ?>" />
		<label class="description" for="domain_name"><?php _e( 'Your Slack team domain name', 'gmt_edd_slack' ); ?></label>
		<?php
	}

	function gmt_edd_slack_settings_field_auth_token() {
		$options = gmt_edd_slack_get_theme_options();
		?>
		<input type="text" name="gmt_edd_slack_theme_options[auth_token]" class="large-text" id="auth_token" value="<?php echo esc_attr( $options['auth_token'] ); ?>" />
		<label class="description" for="auth_token"><?php _e( 'Your Slack authorization token', 'gmt_edd_slack' ); ?></label>
		<?php
	}

	function gmt_edd_slack_settings_field_email_label() {
		$options = gmt_edd_slack_get_theme_options();
		?>
		<input type="text" name="gmt_edd_slack_theme_options[email_label]" class="large-text" id="email_label" value="<?php echo stripslashes( esc_attr( $options['email_label'] ) ); ?>" />
		<label class="description" for="email_label"><?php _e( 'The text to display on the email label', 'gmt_edd_slack' ); ?></label>
		<?php
	}

	function gmt_edd_slack_settings_field_join_button_text() {
		$options = gmt_edd_slack_get_theme_options();
		?>
		<input type="text" name="gmt_edd_slack_theme_options[join_button_text]" class="large-text" id="join_button_text" value="<?php echo stripslashes( esc_attr( $options['join_button_text'] ) ); ?>" />
		<label class="description" for="join_button_text"><?php _e( 'The text to display on the sign-up button', 'gmt_edd_slack' ); ?></label>
		<?php
	}

	function gmt_edd_slack_settings_field_email_message() {
		$options = gmt_edd_slack_get_theme_options();
		?>
		<input type="text" name="gmt_edd_slack_theme_options[email_message]" class="large-text" id="email_message" value="<?php echo stripslashes( esc_attr( $options['email_message'] ) ); ?>" />
		<label class="description" for="email_message"><?php _e( 'Error message when email is invalid', 'gmt_edd_slack' ); ?></label>
		<?php
	}

	function gmt_edd_slack_settings_field_error_message() {
		$options = gmt_edd_slack_get_theme_options();
		?>
		<input type="text" name="gmt_edd_slack_theme_options[error_message]" class="large-text" id="error_message" value="<?php echo stripslashes( esc_attr( $options['error_message'] ) ); ?>" />
		<label class="description" for="error_message"><?php _e( 'Error message when signup fails', 'gmt_edd_slack' ); ?></label>
		<?php
	}

	function gmt_edd_slack_settings_field_success_message() {
		$options = gmt_edd_slack_get_theme_options();
		?>
		<input type="text" name="gmt_edd_slack_theme_options[success_message]" class="large-text" id="success_message" value="<?php echo stripslashes( esc_attr( $options['success_message'] ) ); ?>" />
		<label class="description" for="error_message"><?php _e( 'Message when signup succeeds', 'gmt_edd_slack' ); ?></label>
		<?php
	}



	/**
	 * Theme Option Defaults & Sanitization
	 * Each option field requires a default value under gmt_edd_slack_get_theme_options(), and an if statement under gmt_edd_slack_theme_options_validate();
	 */

	// Get the current options from the database.
	// If none are specified, use these defaults.
	function gmt_edd_slack_get_theme_options() {
		$saved = (array) get_option( 'gmt_edd_slack_theme_options' );
		$defaults = array(
			'domain_name' => '',
			'auth_token' => '',
			'email_label' => 'Your Email Address',
			'join_button_text' => 'Join',
			'email_message' => 'Please use a valid email address',
			'error_message' => 'Sign-up failed. Please try again.',
			'success_message' => 'Success! An invite should arrive in your inbox shortly.',
		);

		$defaults = apply_filters( 'gmt_edd_slack_default_theme_options', $defaults );

		$options = wp_parse_args( $saved, $defaults );
		$options = array_intersect_key( $options, $defaults );

		return $options;
	}

	// Sanitize and validate updated theme options
	function gmt_edd_slack_theme_options_validate( $input ) {
		$output = array();

		if ( isset( $input['domain_name'] ) && ! empty( $input['domain_name'] ) )
			$output['domain_name'] = wp_filter_nohtml_kses( $input['domain_name'] );

		if ( isset( $input['auth_token'] ) && ! empty( $input['auth_token'] ) )
			$output['auth_token'] = wp_filter_nohtml_kses( $input['auth_token'] );

		if ( isset( $input['email_label'] ) && ! empty( $input['email_label'] ) )
			$output['email_label'] = wp_filter_nohtml_kses( $input['email_label'] );

		if ( isset( $input['join_button_text'] ) && ! empty( $input['join_button_text'] ) )
			$output['join_button_text'] = wp_filter_nohtml_kses( $input['join_button_text'] );

		if ( isset( $input['email_message'] ) && ! empty( $input['email_message'] ) )
			$output['email_message'] = wp_filter_nohtml_kses( $input['email_message'] );

		if ( isset( $input['error_message'] ) && ! empty( $input['error_message'] ) )
			$output['error_message'] = wp_filter_nohtml_kses( $input['error_message'] );

		if ( isset( $input['success_message'] ) && ! empty( $input['success_message'] ) )
			$output['success_message'] = wp_filter_nohtml_kses( $input['success_message'] );

		return apply_filters( 'gmt_edd_slack_theme_options_validate', $output, $input );
	}



	/**
	 * Theme Options Menu
	 * Each option field requires its own add_settings_field function.
	 */

	// Create theme options menu
	// The content that's rendered on the menu page.
	function gmt_edd_slack_theme_options_render_page() {
		?>
		<div class="wrap">
			<h2><?php printf( __( 'Slack Invite Settings', 'gmt_edd_slack' ), $theme_name ); ?></h2>

			<form method="post" action="options.php">
				<?php
					settings_fields( 'gmt_edd_slack_options' );
					do_settings_sections( 'theme_options' );
					submit_button();
				?>
			</form>
		</div>
		<?php
	}

	// Register the theme options page and its fields
	function gmt_edd_slack_theme_options_init() {

		// Register a setting and its sanitization callback
		// register_setting( $option_group, $option_name, $sanitize_callback );
		// $option_group - A settings group name.
		// $option_name - The name of an option to sanitize and save.
		// $sanitize_callback - A callback function that sanitizes the option's value.
		register_setting( 'gmt_edd_slack_options', 'gmt_edd_slack_theme_options', 'gmt_edd_slack_theme_options_validate' );


		// Register our settings field group
		// add_settings_section( $id, $title, $callback, $page );
		// $id - Unique identifier for the settings section
		// $title - Section title
		// $callback - // Section callback (we don't want anything)
		// $page - // Menu slug, used to uniquely identify the page. See gmt_edd_slack_theme_options_add_page().
		add_settings_section( 'credentials', 'Credentials',  '__return_false', 'theme_options' );
		add_settings_section( 'form_labels', 'Form Labels',  '__return_false', 'theme_options' );
		add_settings_section( 'messages', 'Messages',  '__return_false', 'theme_options' );


		// Register our individual settings fields
		// add_settings_field( $id, $title, $callback, $page, $section );
		// $id - Unique identifier for the field.
		// $title - Setting field title.
		// $callback - Function that creates the field (from the Theme Option Fields section).
		// $page - The menu page on which to display this field.
		// $section - The section of the settings page in which to show the field.
		add_settings_field( 'domain_name', __( 'Team Name', 'gmt_edd_slack' ), 'gmt_edd_slack_settings_field_domain_name', 'theme_options', 'credentials' );
		add_settings_field( 'auth_token', __( 'Authorization Token', 'gmt_edd_slack' ), 'gmt_edd_slack_settings_field_auth_token', 'theme_options', 'credentials' );

		add_settings_field( 'email_label', __( 'Email Label', 'gmt_edd_slack' ), 'gmt_edd_slack_settings_field_email_label', 'theme_options', 'form_labels' );
		add_settings_field( 'join_button_text', __( 'Email Label', 'gmt_edd_slack' ), 'gmt_edd_slack_settings_field_join_button_text', 'theme_options', 'form_labels' );

		add_settings_field( 'email_message', __( 'Email Error', 'gmt_edd_slack' ), 'gmt_edd_slack_settings_field_email_label', 'theme_options', 'messages' );
		add_settings_field( 'error_message', __( 'Error', 'gmt_edd_slack' ), 'gmt_edd_slack_settings_field_error_message', 'theme_options', 'messages' );
		add_settings_field( 'success_message', __( 'Success', 'gmt_edd_slack' ), 'gmt_edd_slack_settings_field_success_message', 'theme_options', 'messages' );

	}
	add_action( 'admin_init', 'gmt_edd_slack_theme_options_init' );

	// Add the theme options page to the admin menu
	// Use add_theme_page() to add under Appearance tab (default).
	// Use add_menu_page() to add as it's own tab.
	// Use add_submenu_page() to add to another tab.
	function gmt_edd_slack_theme_options_add_page() {

		// add_theme_page( $page_title, $menu_title, $capability, $menu_slug, $function );
		// add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function );
		// add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
		// $page_title - Name of page
		// $menu_title - Label in menu
		// $capability - Capability required
		// $menu_slug - Used to uniquely identify the page
		// $function - Function that renders the options page
		// $theme_page = add_theme_page( __( 'Theme Options', 'gmt_edd_slack' ), __( 'Theme Options', 'gmt_edd_slack' ), 'edit_theme_options', 'theme_options', 'gmt_edd_slack_theme_options_render_page' );

		// $theme_page = add_menu_page( __( 'Theme Options', 'gmt_edd_slack' ), __( 'Theme Options', 'gmt_edd_slack' ), 'edit_theme_options', 'theme_options', 'gmt_edd_slack_theme_options_render_page' );
		$theme_page = add_submenu_page( 'options-general.php', __( 'Slack Settings', 'gmt_edd_slack' ), __( 'Slack Settings', 'gmt_edd_slack' ), 'edit_theme_options', 'slack_settings', 'gmt_edd_slack_theme_options_render_page' );
	}
	add_action( 'admin_menu', 'gmt_edd_slack_theme_options_add_page' );



	// Restrict access to the theme options page to admins
	function gmt_edd_slack_option_page_capability( $capability ) {
		return 'edit_theme_options';
	}
	add_filter( 'option_page_capability_gmt_edd_slack_options', 'gmt_edd_slack_option_page_capability' );
