<?php

/*login module using wordpress hooks */

// Step 1: Create shortcode for login form
function add_login_shortcode() {
    add_shortcode( 'login-form', 'login_form_shortcode' );
}

//Step 2: Shortcode callback function for login
function login_form_shortcode() {
    // Check function user login or not 
        if (is_user_logged_in()){           
            echo '<p>Welcome. You are logged in!</p>'; ?>
    <!-- After login page will redirect for same custom login page. -->
        <a href="<?php echo wp_logout_url( home_url('/login/') ); ?>">Logout</a>
        <?php
        }else{ 
        // wordpress login form 
        wp_login_form( 
                array(
                        'echo'           => true,
                        // Default 'redirect' value takes the user back to the request URI.
                        // 'redirect'       => ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
                        // Redirect to custom page 
                        'redirect'      =>'http://localhost/wordpress/about-us/',
                        'form_id'        => 'loginform',
                        'label_username' => __( 'Your Username' ),
                        'label_password' => __( 'Your Password' ),
                        'label_remember' => __( 'Remember Me' ),
                        'label_log_in'   => __( 'Log In' ),
                        'id_username'    => 'user_login',
                        'id_password'    => 'user_pass',
                        'id_remember'    => 'rememberme',
                        'id_submit'      => 'wp-submit',
                        'remember'       => true,
                        'value_username' => '',
                        // Set 'value_remember' to true to default the "Remember me" checkbox to checked.
                        'value_remember' => false,
                    )
                                
                );
            }
}   
// Step 3 : Init the shortcode function
add_action( 'init', 'add_login_shortcode' );

//Step 4 : Use the shortcode [login-form] to embed the login form on a page or post 

?>