<?php
/* Register custom api  for email with otp*/
add_action('rest_api_init', 'register_api_for_email_with_otp');
function register_api_for_email_with_otp()
{
    register_rest_route('email', '/otp/', //endpoint url : https://webbygenius.com/deepak/wp-json/email/otp/
    array(
        'methods' => 'POST',
        'callback' => 'login_with_email_otp',
    ));
}

/*Api Callbacck functions*/
function login_with_email_otp($request)
{
    /*Get inforamtions from server*/
    $body_params = $request->get_params();
    $user_exists = false;
    $user_email = $body_params['user_email'];

    /*Check email exists or not */
    if (email_exists($user_email))
    {
        $msg_emial_otp = rand(000000, 999999);
        $user = get_user_by('email', $user_email);
        $userId = $user->ID;
        if (get_user_meta($userId, 'user_otp', true))
        {
            update_user_meta($userId, 'user_otp', $msg_emial_otp);
        }
        else
        {
            add_user_meta($userId, 'user_otp', $msg_emial_otp);
        }

        $response_message = ['status' => 200, //valid request
        'message' => 'otp send successfully !', 'email-otp' => $msg_emial_otp];

        /*Send otp via mail */
        $mag = '<p>Welcome to <strong>https://webbygenius.com/deepak/</strong> your verification OTP is : '. $msg_emial_otp . ' </p>';
        wp_mail($user_email, 'OTP login verification', $msg);

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

/*Otp Api compare with email
 * Register api for compare otp with email
*/
add_action('rest_api_init', 'compare_api_for_email_with_otp');

function compare_api_for_email_with_otp()
{
  register_rest_route('compare/email', '/otp/', //endpoint url : https://webbygenius.com/deepak/wp-json/compare/email/otp/
    array(
        'methods' => 'POST',
        'callback' => 'compare_otp_with_email'
    ));
}

/*Api Callback Functions */
function compare_otp_with_email($request)
{
    /*Get inforamtions from server*/
    $body_params = $request->get_params();
    $user_exists = false;
    $user_email = $body_params['user_email'];
    $user_otp = $body_params['user_otp'];

    /* Read otp from wp-usermeta table*/
    $user = get_user_by('email', $user_email);
    $userId = $user->ID;
    $user_meta = get_user_meta($userId, 'user_otp', true);

    /*Check otp databse table from server side*/
    if ($user_otp == $user_meta)
    {
        $response_message = ['status' => 200, //valid request
        'message' => 'successfully !'];
    }
    else
    {
        $response_message = ['status' => 401, // invalid request
        'message' => 'Incorrect otp !'];
    }

    if (is_wp_error($user))
    {
        return new WP_Error('user_not_exists', $response_message);
    }
    return rest_ensure_response($response_message);
}



?>
