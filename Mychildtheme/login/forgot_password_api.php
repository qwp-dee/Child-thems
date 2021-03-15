<?php
/* Register custom api  for forgot password
    1.Create custom api for forgate password to send email change password link.
    2.Create another api for user can add new password and new password.
*/
add_action('rest_api_init', 'forgot_password_api');
add_filter( 'password_reset_expiration', function( $expiration ) {
    return 60; // A minute
});
function forgot_password_api() 
{   
     register_rest_route('forgot', '/password/', array('methods'=> 'POST',                        
                         'callback' => 'send_email_change_forgot_password' ));
}
/*Api Callbacck functions*/
function send_email_change_forgot_password($request) {
    
/*Get inforamtions from server*/
    $body_params = $request->get_params();
    $user_exists = false;
    $user_email = $body_params['user_email'];
    
    /*Check email exists or not */
    if (email_exists($user_email))
    {
        $user = get_user_by('email', $user_email);
        $userId = $user->ID;
        $token = md5(microtime (TRUE)*100000);
    
        $tokenToSendInMail = $token;
      echo  $tokenToStoreInDB = hash($token, $user);
                exit;
        if (get_user_meta($userId, 'user_fogot_token', true))
        {
            update_user_meta($userId, 'user_fogot_token', $tokenToStoreInDB);
        }
        else
        {
            add_user_meta($userId, 'user_fogot_token', $tokenToStoreInDB);
        }

        $redirect_page = "You can change your password here https://webbygenius.com/deepak/wp-json/new/password/" ;

            $response_message = ['status' => 200, //valid request
            'message' => 'forgot password link send successfully !',
            'send_email' => $redirect_page ];

            /*Send otp via mail */
            $msg = 'Welcome to https://webbygenius.com/deepak/ your verification email is : '. $redirect_page . $tokenToStoreInDB ;
            
            wp_mail($user_email, 'Forgot Password Link ', $msg);

        }
        else
        {
        $response_message = ['status' => 404, //valid request
        'message' => 'User not exists!', ];
        }
    
        if (is_wp_error($user))
        {
            return new WP_Error('user_not_exists', $response_message);
        }
        return rest_ensure_response($response_message);

}

/*Add new password and confirm password api*/

add_action('rest_api_init', 'add_new_password_api');

function add_new_password_api(){
      register_rest_route('new', '/password/', array('methods'=> 'POST',  'callback' => 'add_new_password' ));   
}

function add_new_password($request){
    /*Get inforamtions from server*/
    $body_params = $request->get_params(); //recive inforamtions from server
    $user_exists = false;
    $user_email = $body_params['user_email']; //get useremail from server
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
        $new_password = $_REQUEST['add_new_password'];
        $confirm_password = $_REQUEST['add_confirm_password'];
        
        if ($new_password == $confirm_password && !empty ($new_password )) {
             wp_set_password($confirm_password, $user->ID);
             $response_message = ['status' => 200, //success
            'message' => 'Password Changed Successfully..!'];
            
        } else {
            $response_message = ['status' => 401, // Unauthorized
            'message' => 'Your password is mismatch !'];
        }
    }
    if (is_wp_error($user)) {
        return new WP_Error('user_not_exists', $response_message);
    }
    return rest_ensure_response($response_message);
}
?>

