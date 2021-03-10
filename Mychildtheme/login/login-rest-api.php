<?php


// Register custom api 
add_action( 'rest_api_init', 'register_api_hooks' );

function register_api_hooks() {
  register_rest_route(
    'custom', '/login/',        //custo is api neame and login is endpoint url
    array(
      'methods'  => 'POST',			//post method  user for send our data.
      'callback' => 'login',		//callback functions  after sending our data for response 
    )
  );
}	


function login($request){				//callback functions

	$body_params = $request->get_params();	  //recive inforamtions from server
	$user_exists = false;							
	$user_email = $body_params['user_email'];		//get useremail from server
	$user_password = $body_params['user_password'];
	$user = get_user_by_email($user_email);

if (email_exists($user_email)) {					//check email exists or not 
	$user_exists = true;
	$user = get_user_by_email($user_email);
} else {
	$response_message = [
	'status' => 404,  //invalid request
	'message' => 'Email address not exists !'
	];
}

if ($user_exists) {
	$user_email = $user->user_email;
	$login_data = array();
	$login_data['user_login'] = $user_email;
	$login_data['user_password'] = $user_password;

if (!wp_check_password($user_password, $user->user_pass, $user->ID)) {
		$response_message = [
		'status' => 401, // Unauthorized
		'message' => 'Incorrect password !'
		];
}else{
		$response_message = [
		'status' => 200, //success
		'message' => 'Successfully Sign in !'
		];
  	}
}

if (is_wp_error($user)) {
	return new WP_Error('user_not_exists', $response_message);
}
	return rest_ensure_response($response_message);
}