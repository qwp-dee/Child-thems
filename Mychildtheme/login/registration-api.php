<?php
/*Custom Registration  api*/
add_action( 'rest_api_init', 'users_registration_api' );
	function users_registration_api() {
	  register_rest_route('users', '/registration/',       
			 array( 'methods'  => 'POST','callback' => 'users_registration_custom_api'));		   
	}	

 function users_registration_custom_api($request){				
 		 /*Get inforamtions from server*/
   		 $body_params = $request->get_params();          
		 $first_name = $_REQUEST['first_name'];
		 $last_name = $_REQUEST['last_name'];
         $username =  $_REQUEST['username'];
         $email =  $_REQUEST['email'];
         $password =  $_REQUEST['password'];
         
    	global $customize_error_validation;
        $customize_error_validation = new WP_Error;
        if ( empty( $username ) || empty( $password ) || empty( $email ) ) {
              $response_message = ['status' => 401, //Not Acceptable
                'message' => 'Please fillthe filed of registration form'];
            
            // $customize_error_validation->add('field', ' Please Fill the filed of WordPress registration form');
        }
        if ( username_exists( $username ) )
            $customize_error_validation->add('user_name', ' User Already Exist');
        if ( is_wp_error( $customize_error_validation ) ) {
            foreach ( $customize_error_validation->get_error_messages() as $error ) {
            //  echo '<strong>Hold</strong>:';
            //  echo $error . '<br/>';
             $response_message = ['status' => 406, //success
            'message' => $error ];
            }
        }    
        
        if ( 1 > count( $customize_error_validation->get_error_messages() ) ) {
        $userdata = array(
         'first_name' =>   $first_name,
         'last_name' =>   $last_name,
         'user_login' =>   $username,
         'user_email' =>   $email,
         'user_pass' =>   $password,
 
        );
        $user = wp_insert_user( $userdata );
        $response_message = ['status' => 200, //success
            'message' => 'Registartion Successfully..!'];
  
    }else{
        $response_message = ['status' => 401, // Unauthorized
            'message' => 'Registartion Failed'];
    }
        
              
if (is_wp_error($user)) {
	return new WP_Error('user_not_exists', $response_message);
}
	return rest_ensure_response($response_message);
}
?>
