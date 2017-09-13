<?php


	/**
	 * Slack invite form shortcode
	 */
	function gmt_edd_slack_form() {

		// Variables
		$options = gmt_edd_slack_get_theme_options();
		$error = gmt_edd_slack_get_session( 'gmt_edd_slack_error', true );
		$success = gmt_edd_slack_get_session( 'gmt_edd_slack_success', true );
		$email = gmt_edd_slack_get_session( 'gmt_edd_slack_email', true );
		if ( is_user_logged_in() && empty( $email ) ) {
			$current_user = wp_get_current_user();
			$email = $current_user->user_email;
		}


		if (!empty($success)) {
			$form = '<div class="gmt-edd-slack-alert gmt-edd-slack-alert-success" id="gmt_edd_slack">' . stripslashes( $success ) . '</div>';
		} else {
			$form =
				'<form class="gmt-edd-slack-form" id="gmt_edd_slack" name="gmt_edd_slack" action="" method="post">' .

					( empty( $error ) ? '' : '<div class="gmt-edd-slack-alert gmt-edd-slack-alert-error">' . stripslashes( $error ) . '</div>' ) .

					'<label class="gmt-edd-slack-form-label" for="gmt_edd_slack_email">' . stripslashes( $options['email_label'] ) . '</label>' .
					'<div class="gmt-edd-slack-row">' .
						'<div class="gmt-edd-slack-grid-input">' .
							'<input type="text" name="gmt_edd_slack_email" id="gmt_edd_slack_email" value="' . esc_attr( $email ) . '">' .
						'</div>'.
						'<div class="gmt-edd-slack-grid-button">' .
							'<button class="gmt-edd-slack-form-button">' . stripslashes( $options['join_button_text'] ) . '</button>' .
						'</div>' .
					'</div>' .

					'<input type="hidden" id="gmt_edd_slack_submit" name="gmt_edd_slack_submit" value="' . get_site_option( 'gmt_edd_slack_submit_hash' ) . '">' .

				'</form>';
		}

		return $form;

	}
	add_shortcode( 'slack_signup', 'gmt_edd_slack_form' );



	/**
	 * Process Slack invite
	 */
	function gmt_edd_slack_process_form() {

		// Check that form was submitted
		if ( !isset( $_POST['gmt_edd_slack_submit'] ) ) return;

		// Verify data came from proper screen
		if ( strcmp( $_POST['gmt_edd_slack_submit'], get_site_option( 'gmt_edd_slack_submit_hash' ) ) !== 0 ) return;

		// Variables
		$options = gmt_edd_slack_get_theme_options();
		$referer = add_query_arg( 'gmt-edd-slack', 'submitted', esc_url_raw( gmt_edd_slack_get_url() ) . '#gmt_edd_slack' );
		$email = isset( $_POST['gmt_edd_slack_email'] ) ? $_POST['gmt_edd_slack_email'] : '';

		// Make sure valid credentials exist
		if ( empty( $options['domain_name'] ) || empty( $options['auth_token'] ) ) {
			gmt_edd_slack_set_session( 'gmt_edd_slack_error', $options['error_message'] );
			wp_safe_redirect( $referer, 302 );
			exit;
		}

		// Store email for reuse
		gmt_edd_slack_set_session( 'gmt_edd_slack_email', wp_filter_post_kses( $_POST['gmt_edd_slack_email'] ) );

		// Check that email is supplied and valid
		if ( empty( $_POST['gmt_edd_slack_email'] ) || !is_email( $_POST['gmt_edd_slack_email'] ) ) {
			gmt_edd_slack_set_session( 'gmt_edd_slack_error', $options['email_message'] );
			wp_safe_redirect( $referer, 302 );
			exit;
		}

		// Invite purchaser to Slack
		$slack = new Slack_Invite( $options['auth_token'], $options['domain_name'] );
		$invitation = $slack->send_invite( sanitize_email( $_POST['gmt_edd_slack_email'] ) );

		// If invite successful
		if ( is_array( $invitation ) && array_key_exists( 'ok', $invitation ) ) {
			gmt_edd_slack_set_session( 'gmt_edd_slack_success', $options['success_message'] );
			do_action( 'gmt_edd_invite_to_slack_after', sanitize_email( $_POST['gmt_edd_slack_email'] ) );
			wp_safe_redirect( $referer, 302 );
			exit;
		}

		// Otherwise fail
		gmt_edd_slack_set_session( 'gmt_edd_slack_error', $options['error_message'] );
		wp_safe_redirect( $referer, 302 );
		exit;

	}
	add_action( 'init', 'gmt_edd_slack_process_form' );