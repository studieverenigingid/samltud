<?php
/*
Plugin Name: SAMLTUD (login with NetID)
Plugin URI: https://github.com/studieverenigingid/samltud
Description: Use SAML to allow TU Delft NetID login. Based on https://github.com/ktbartholomew/saml-20-single-sign-on.
Author: Floris Jansen (Study association i.d), ktbartholomew
Version: 0.2.1
Author URI: https://fmjansen.nl
*/

defined('ABSPATH') or die('nope');

define('WP_OPTION_NAME', 'samltud_options');

define('CERT_DIR', plugin_dir_path(__FILE__) . 'simplesamlphp/cert/generated/'); //out
define('CERT_PATH', CERT_DIR . 'sp.pem'); //out

$upload_dir = wp_upload_dir();
define('SAMLTUD_AUTH_CONF', $upload_dir['basedir'] . '/samltud/etc');
define('SAMLTUD_AUTH_CONF_URL', $upload_dir['baseurl'] . '/samltud/etc');

define('SAMLTUD_PLUGIN_NAME', plugin_basename( __FILE__ ) );
define('SAMLTUD_AUTH_ROOT', plugin_dir_path(__FILE__) );
define('SAMLTUD_AUTH_URL', plugins_url() . '/' . basename( dirname(__FILE__) ) );

if (!defined('SAMLTUD_SLUG')) define('SAMLTUD_SLUG', 'tud_dev_sp_idweb');
define('SAMLTUD_AUTH_MD_URL', constant('SAMLTUD_AUTH_URL') . '/simplesamlphp/www/module.php/saml/sp/metadata.php/' . constant('SAMLTUD_SLUG') );

require_once( constant('SAMLTUD_AUTH_ROOT') . 'includes/classes/samltud_settings.php' );
require_once( constant('SAMLTUD_AUTH_ROOT') . 'includes/classes/samltud_client.php' );

$SAML_Client = new SAML_Client();



function add_samltud_admin() {
	if ( is_admin() ) {
		require plugin_dir_path(__FILE__) . 'includes/classes/samltud_admin.php';
		$samltud_admin = new SAMLTUD_admin();
	}
}

add_samltud_admin();
