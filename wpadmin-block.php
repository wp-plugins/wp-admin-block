<?php
/*
	Plugin Name: WP Admin Block
	Plugin URI: http://blog.blackbirdi.com/
	Description: Block all your users from accessing the admin area through /wp-admin/ or wp-login.php without a hidden key!
	Version: 1.3
	Author: Blackbird Interactive
	Author URI: http://blackbirdi.com
	License: GPL2



    Copyright 2010 Blackbird Interactive (email : justin@blackbirdi.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
?>
<?php

# Compatibilty checks
# -----------------------------------------------------

// get wordpress version number and fill it up to 9 digits
$int_wp_version = preg_replace('#[^0-9]#', '', get_bloginfo('version'));
while(strlen($int_wp_version) < 9){
	
	$int_wp_version .= '0'; 
}

// get php version number and fill it up to 9 digits
$int_php_version = preg_replace('#[^0-9]#', '', phpversion());
while(strlen($int_php_version) < 9){
	
	$int_php_version .= '0'; 
}

// Check overall plugin compatibility
if(	$int_wp_version >= 300000000 && 		// Wordpress version > 2.7
	$int_php_version >= 520000000 && 		// PHP version > 5.2
	defined('ABSPATH') && 					// Plugin is not loaded directly
	defined('WPINC')) {						// Plugin is not loaded directly
		
	// Load plugin class file
	require_once(dirname(__FILE__).'/assets/lib/class.main.php');
	
	// Intialize the plugin class by calling initialize on our class
	add_action('init',array('wpblockadmin','initialize'));
	
}

// Plugin is not compatible with current configuration
else {
	
	// Display incompatibility information
	add_action('admin_notices', 'wpblockadmin_incompatibility_notification');
}

// Display incompatibility notification
function wpblockadmin_incompatibility_notification(){
	
	echo '<div id="message" class="error">
	
	<p><b>The &quot;WP Block &quot; Plugin does not work on this WordPress installation!</b></p>
	<p>Please check your WordPress installation for following minimum requirements:</p>
	
	<p>
	- WordPress version 3.0 or higer<br />
	- PHP version 5.2 or higher<br />
	</p>
	
	<p>Do you need help? Contact <a href="mailto:wpblockadmin@blackbirdi.com">Blackbird Interactive</a></p>
	
	</div>';
}

add_action('init', 'process_post');

function process_post(){

##################################################################
# DON"T LET ANYONE IN THE WP-ADMIN AREA UNLESS THEY ARE USER ID 1
##################################################################
$string = 'wp-admin';

$login 	= 'wp-login.php';

$pos = strpos($_SERVER['REQUEST_URI'], $string);

$pos1 = strpos($_SERVER['REQUEST_URI'], $login);

$pos3 = strpos($_SERVER['HTTP_REFERER'], $string);

$pos4 = strpos($_SERVER['HTTP_REFERER'], $login);

// Check if the blog is multisite or not
if (is_multisite()){

$option = get_blog_option('1','wpblockadmin_option_value'); // Grab the option from the FIRST/ MASTER blog

} else {

	$option = get_option('wpblockadmin_option_value'); // Site is not multisite so we just need to get the value

}

// If the user is not logged in and did not come from the login screen then redirect them
if ($pos == true){
	
	if ($pos4 != true){		
		
		// Check the user id number and if it is not 1 redirect them to htpp://cravespot.com
		if (!is_user_logged_in()){
					
			// Redirect them if they are not logged in
			wp_redirect( home_url() ); exit;
		
		}
			
	}

	if (is_user_logged_in()){
		
		// Check the id of the user and if it is not 1 then redirect them to the cravespot homepage 
		global $current_user;
		
      	get_currentuserinfo();
		
		if ($current_user->ID != 1){
			
			// Redirect the user to the main homepage to hide the admin
			wp_redirect( home_url() ); exit;
			
		}
	
	}
	
}

#####################################
# Checks for wp-login
#####################################	
// NOW CHECK FOR WP-LOGIN
if ($pos1 == true) {
	
	// If the user did not come from the wp-admin then they have not been logged in and we need to redirect them
	if ($pos3 != true){
		
		// Check for GET
		if ($_GET){
			
			// Check if key is empty and if so, set key to default
			if ($option == ''){
				
				$option = '1111';
				
				}
			
			// Check for the key
			if ($_GET['access'] != $option){
				
				// Redirect the user to the main homepage to hide the admin
				wp_redirect( home_url() ); exit;
				
			}			
		
			} else if ($pos4 != true) {
				
				wp_redirect( home_url() ); exit;
				
			}
		
	}	
	}
 }


?>