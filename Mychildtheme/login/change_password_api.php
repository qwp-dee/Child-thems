<?php
/* Register custom api  for email with otp*/
add_action('rest_api_init', 'change_password_api');
function change_password_api()
{
    register_rest_route('change', '/password/', //endpoint url : https://webbygenius.com/deepak/wp-json/email/otp/
    array(
        'methods' => 'POST',
        'callback' => 'password_changed_api',
    ));
}

/*Api Callbacck functions*/
function password_changed_api($request){
	return "Your password  is change";

}




?>