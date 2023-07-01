<?php
/* Register custom api  for change password
    1. Create custom api endpoint url check user login or not and then allow to change password.
*/
add_action('rest_api_init', 'change_password_api');
function change_password_api() {
    /* url : https://yoursite.com/deepak/wp-json/change/password/ */
    register_rest_route('change', '/password/', 
    array('methods' => 'POST', 'callback' => 'password_changed_api',));
}
/*Api Callbacck functions*/
function password_changed_api($request) {
    /*Get inforamtions from server*/
    $body_params = $request->get_params(); //recive inforamtions from server
    $user_exists = false;
    $user_email = $body_params['user_email']; //get useremail from server
    $user_password = $body_params['user_current_password'];
    $user = get_user_by_email($user_email);
    if (email_exists($user_email)) { //check email exists or not
        $user_exists = true;
        $user = get_user_by_email($user_email);
    } else {
        $response_message = ['status' => 404, //invalid request
        'message' => 'Email address not exists !'];
    }
    /*Check users login or not and allow to change password */
    if ($user_exists) {
        $user_email = $user->user_email;
        $login_data = array();
        $login_data['user_password'] = $user_password;
        $change_password = $_REQUEST['user_change_pass'];
        if (!wp_check_password($user_password, $user->user_pass, $user->ID)) {
            $response_message = ['status' => 401, // Unauthorized
            'message' => 'Incorrect password !'];
        } else {
            wp_set_password($change_password, $user->ID);
            $response_message = ['status' => 200, //success
            'message' => 'Password Changed Successfully..!'];
        }
    }
    if (is_wp_error($user)) {
        return new WP_Error('user_not_exists', $response_message);
    }
    return rest_ensure_response($response_message);
}
?>
