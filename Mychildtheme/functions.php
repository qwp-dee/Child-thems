<?php
/*This file is part of Mychildtheme, twentyseventeen child theme.

All functions of this file will be loaded before of parent theme functions.

*/

define('CHI_PRENT_THEME_URI', get_template_directory_uri());
define('CHI_THEME_DIR', get_stylesheet_directory());
define('CHI_THEME_URI', get_stylesheet_directory_uri());
define('CHI_THEME_NAME', 'CHILD THEME');
define('CHI_THEME_VERSION', '1.0');
define('CHI_SITE_URL', SITE_URL());
define('CHI_FUNCTION_DIR', CHI_THEME_DIR.'/functions');
define('CHI_CPT_DIR', CHI_THEME_DIR.'/cpt');
define('CHI_LOGIN_DIR', CHI_THEME_DIR.'/login');


// Load theme files
require_once(CHI_CPT_DIR.'/woo-widgets.php');

// Load header theme functions
require_once(CHI_FUNCTION_DIR.'/theme-head.php');

// Load theme action file 
require_once(CHI_FUNCTION_DIR.'/theme-action.php');

// Metabox for post 
require_once(CHI_FUNCTION_DIR.'/wpmediaMetabox.php');

/*Load post type and post listing files*/
require_once(CHI_FUNCTION_DIR.'/post-listing.php');

/*Load custom login files*/
require_once(CHI_LOGIN_DIR.'/login.php');

/*Load custom registration files*/
require_once(CHI_LOGIN_DIR.'/registration.php');

/* Load custom login rest api files*/
require_once(CHI_LOGIN_DIR.'/login-rest-api.php');

/*Load forgate passowrd type file*/
require_once(CHI_LOGIN_DIR.'/login-email-otp.php');

/*Load login with email otp*/
require_once(CHI_LOGIN_DIR.'/login-email-otp-api.php');

/*Change password api*/
require_once(CHI_LOGIN_DIR.'/change_password_api.php');





/*Date : 28-Dec-2020*/

function wpshout_filter_example( $title ) {
    $upper = strtoupper($title);
    return $upper;
    // return 'Hooked: ' . $title;
}
add_filter( 'the_title', 'wpshout_filter_example' );

function content_uppercase($content){
    $word= wordwrap($content,55,"<br>\n");
    return strtoupper($word);
}
add_filter('the_content','content_uppercase');

function wpshout_action_example( ) {
    echo '<div style="text-align: center; padding:20px;">WPShout was here.</div>';
}
add_action( 'wp_footer', 'wpshout_action_example' );





$metakey   = 'Funny Phrases';
$metavalue = "WordPress' database interface is like Sunday Morning: Easy.";
 
$wpdb->query(
   $wpdb->prepare(
   "
   INSERT INTO $wpdb->postmeta
   ( post_id, meta_key, meta_value )
   VALUES ( %d, %s, %s )
   ",
   array(
         10,
         $metakey,
         $metavalue,
      )
   )
);








?>
