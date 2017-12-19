<?php

/*
Plugin Name: CAS Confirmer
Plugin URI: http://drstroberi.com
Description: CAS Client on page (last version)
Author: Basuki Setyohadi
Version: 1.0
Author URI: http://drstroberi.com
*/

if (!session_id()) session_start();

define('casEnabled',true);

define('CAS_BASE_DIR', 'CAS-1.3.0/');
define('casServer','cas.unpar.ac.id');
define('casPort',443);
define('casPath','');

include CAS_BASE_DIR.'CAS.php'; 

function cas_logout() {
	if (isset($_POST['caslogout'])) {
		$casmodule = new CASModule;
		$casmodule->logout();
	}
	if (isset($_GET['caslogoutnoback'])) {
		$casmodule = new CASModule;
		$casmodule->logoutnoback();
	}
	if (isset($_POST['caslanjut']) || $_SESSION['CASLogin']) {
		$_SESSION['CASLogin'] = true;
		$casmodule = new CASModule;
		$user = $casmodule->authenticate();
		$_SESSION['CASUser'] = $user;
	}
}

class casconfirm {
	function result($content="") {
		$function_keyword_start = '[casconfirm]';
		$function_keyword_end = '[/casconfirm]';
		if (!strpos($content,'[casconfirm]')) return $content;
		list($upper,$str) = explode('[casconfirm]',$content,2);
		list($body,$lower) = explode('[/casconfirm]',$str,2);
				
		$user = $_SESSION['CASUser'];
		if ($user.'x'!='x') {
			unset($_SESSION['CASLogin']);
			return self::caption_status().$upper.$body.$lower;
		}
		return $upper.self::pp_div('<div style="text-align:center"><form method="POST"><input type="submit" value="Login to My UNPARable" name="caslanjut"></form></div>').$lower;
	}

	function caption_status() {
		return self::pp_div(self::pp_div('<form method="post" align="right"> <input type="submit" value="Logout" name="caslogout"></form><br>'));
	}
	
	function pp_div($content) {
		return $content;
		$divstart = '<div style="border-top: 1px solid #CCCCCC; border-bottom: 1px solid #CCCCCC; padding-left: 10px; padding-right: 10px; background-color: #E9E9E9">';
		return $divstart.$content.'</div>';
	}
}

class CASModule {
	function authenticate() {
		phpCAS::client(CAS_VERSION_2_0,casServer,casPort,casPath);
		phpCAS::setNoCasServerValidation();
		phpCAS::forceAuthentication(); 
		phpCAS::isAuthenticated();
		$user = phpCAS::getUser();
		return $user;
	}
	
	function logout() {
		phpCAS::client(CAS_VERSION_2_0,casServer,casPort,casPath);
		phpCAS::setNoCasServerValidation();
		phpCAS::forceAuthentication(); 
		phpCAS::logoutWithRedirectService(self::curPageURL());
		exit;
	}

	function logoutnoback() {
		phpCAS::client(CAS_VERSION_2_0,casServer,casPort,casPath);
		phpCAS::setNoCasServerValidation();
		phpCAS::forceAuthentication(); 
		phpCAS::logout();
		exit;
	}

	function curPageURL() {
		$pageURL = 'http';
		if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
		$pageURL .= "://";
		if ($_SERVER["SERVER_PORT"] != "80") {
			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		} else {
			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
		return $pageURL;
		}
}

class adminSiteCAS {
	function authenticate() {
/*
		$casmodule = new CASModule;
		$user = $casmodule->authenticate();
		if ( $user = get_user_by('email', phpCAS::getUser() )) {
			wp_set_auth_cookie( $user->ID );
			if( isset( $_GET['redirect_to'] )){
				wp_redirect( preg_match( '/^http/', $_GET['redirect_to'] ) ? $_GET['redirect_to'] : site_url( $_GET['redirect_to'] ));
			} else {
				wp_redirect( site_url( '/' ));
			}
		} else {
			wp_redirect( site_url( '/').'/?caslogoutnoback=Y');
		}
*/
		global $CASUnCalled;
		$CASUnCalled = false;
		phpCAS::client(CAS_VERSION_2_0,'cas.unpar.ac.id',443,'');
		phpCAS::setNoCasServerValidation();
		phpCAS::forceAuthentication(); 
		if( phpCAS::isAuthenticated() ){
			// CAS was successful
			if ( $user = get_user_by('email', phpCAS::getUser() )){ // user already exists
				// the CAS user has a WP account
				wp_set_auth_cookie( $user->ID );

				if( isset( $_GET['redirect_to'] )){
					wp_redirect( preg_match( '/^http/', $_GET['redirect_to'] ) ? $_GET['redirect_to'] : site_url( $_GET['redirect_to'] ));
					die();
				}

				wp_redirect( site_url( '/' ));
				die();

			}else{
				phpCAS::logout();
				// the CAS user _does_not_have_ a WP account
			}
		}else{
			// hey, authenticate
			phpCAS::forceAuthentication();
			die();
		}

	}
	
	function logout() {
		wp_redirect( site_url( '/').'/?caslogoutnoback=Y');
	}

	// hide password fields on user profile page.
	function show_password_fields( $show_password_fields ) {
		if ( current_user_can('create_users') ) return true;
		return false;
	}

	// disabled reset, lost, and retrieve password features
	function disable_function() {
		die( __( 'Sorry, this feature is disabled.', 'wpcas' ));
	}

	// set the passwords on user creation
	// patched Mar 25 2010 by Jonathan Rogers jonathan via findyourfans.com
	function check_passwords( $user, $pass1, $pass2 ) {
		$random_password = substr( md5( uniqid( microtime( ))), 0, 8 );
		$pass1=$pass2=$random_password;
	}
}

add_filter('wp_title','sweety_page_title',10,1);

function sweety_page_title($title){
    $title='Your new title'; //define your title here
    return $title;
}

class noCAS {
	function check_passwords( $user, $pass1, $pass2 ) {
		$pass1=$pass2=$defaultPwd;
	}
}

/*
function wps_admin_bar() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('wp-logo');
    $wp_admin_bar->remove_menu('about');
    $wp_admin_bar->remove_menu('wporg');
    $wp_admin_bar->remove_menu('documentation');
    $wp_admin_bar->remove_menu('support-forums');
    $wp_admin_bar->remove_menu('feedback');
    $wp_admin_bar->remove_menu('view-site');
}
*/

function CAS_widget($args) {
	extract($args);
	echo $before_widget;
	if ($_SESSION['appuser']) {
		$content = '<p><b>'.$_SESSION['appuser'].'</b></p><form method="post"><input type="submit" value="Exit and Logout" name="act"></form>';
		$content = '<div style="border-top: 1px solid #CCCCCC; border-bottom: 1px solid #CCCCCC; padding-left: 10px; padding-right: 10px; background-color: #E9E9E9">'.$divstart.$content.'</div>';
		echo $before_widget;
		echo "<h5>Profile account</h5>";
		echo $content;
	} else {
		echo '<p>If you wish to login then please press the button below.</p><form method="get"><input type="submit" value="Authenticate me now" name="caslanjut"></form>';
	}
	echo $after_widget;
}

if (casEnabled) {
	add_action( 'init', 'cas_logout' );
	add_filter('the_content', array('casconfirm', 'result') );

	wp_register_sidebar_widget('CAS_widget', 'CAS_widget', 'CAS_widget', array('description' => 'CAS Widget')); // your unique widget id,widget name,callback function

	add_action('wp_authenticate', array('adminSiteCAS', 'authenticate'), 10, 2);
	add_action('wp_logout', array('adminSiteCAS', 'logout'));
	add_action('lost_password', array('adminSiteCAS', 'disable_function'));
	add_action('retrieve_password', array('adminSiteCAS', 'disable_function'));
	add_action('check_passwords', array('adminSiteCAS', 'check_passwords'), 10, 3);
	add_action('password_reset', array('adminSiteCAS', 'disable_function'));
	add_filter('show_password_fields', array('adminSiteCAS', 'show_password_fields'));

	//add_action( 'wp_before_admin_bar_render', 'wps_admin_bar' );
} else {
	$_SESSION['CASUser'] = 'basuki@unpar.ac.id';
}

function remove_dashboard_widgets() {
	global $wp_meta_boxes;

	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);

}

add_action('wp_dashboard_setup', 'remove_dashboard_widgets' );

function remove_menus () {
    global $menu;
    $restricted = array(__('Dashboard'));
    //$restricted = array(__('Dashboard'), __('Posts'), __('Media'), __('Links'), __('Pages'), __('Appearance'), __('Tools'), __('Users'), __('Settings'), __('Comments'), __('Plugins'));
    end($menu);
    while(prev($menu)){
        $value = explode(' ',$menu[key($menu)][0]);
        if(in_array($value[0]!= NULL?$value[0]:'',$restricted)){unset($menu[key($menu)]);}
    }
}
add_action('admin_menu','remove_menus');

?>
