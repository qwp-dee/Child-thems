<?php

 
function yh_send_a_custom_email_example( $user_id ) {
	//Get user email from their WordPress user ID.
	$user = get_user_by( 'ID', $user_id );
	$email = $user->user_email;

	// Setup email data
	$subject = "Thank you for registering on my site!";
	$message = "Hi there, Thank you for signing up for our site. An administrator will be in touch shortly to confirm your account.";
	$headers = $headers = array('Content-Type: text/html; charset=UTF-8', 'From: Andrew <deepakshukla.com>');

	wp_mail( $email, $subject, $message, $headers );
}
add_action( 'wp_zapier_after_create_user', 'yh_send_a_custom_email_example', 10, 1 );

?>