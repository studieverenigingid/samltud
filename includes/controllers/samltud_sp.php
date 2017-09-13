<?php

// Setup Default Options Array

if (isset($_POST['submit']) && wp_verify_nonce($_POST['_wpnonce'], 'samltudsp') ) {
  $upload_dir = constant('SAMLTUD_AUTH_CONF') . '/certs/tud_dev_sp_idweb';

  if( !is_dir($upload_dir)) {
    // Create all parent directories to store certs
    mkdir($upload_dir, 0775, true);
  }

  if( isset($_POST['auto_cert']) ) {
    $pk = openssl_pkey_new(array('private_key_bits' => 2048, 'private_key_type' => OPENSSL_KEYTYPE_RSA));

    require_once constant('SAMLTUD_AUTH_ROOT') . 'includes/classes/samltud_certificate.php';
    $samltud_cert = new SAMLTUD_certificate();

    //store keys in database
    $this->settings->set_public_key($samltud_cert->cert);
    $this->settings->set_private_key($samltud_cert->pkey);

    //write the private key on save for simple saml parsing
    $key_uploaded = ( file_put_contents($upload_dir . '/tud_dev_sp_idweb.key', $samltud_cert->pkey) ) ? true : false;
  }

  // Update settings
  $this->settings->enable_cache();

  $this->settings->set_attribute('username', $_POST['username_attribute']);
  $this->settings->set_attribute('firstname', $_POST['firstname_attribute']);
  $this->settings->set_attribute('lastname', $_POST['lastname_attribute']);
  $this->settings->set_attribute('email', $_POST['email_attribute']);

  $this->settings->set_idp($_POST['idp']);
  $this->settings->set_nameidpolicy($_POST['nameidpolicy']);

  $this->settings->disable_cache();

}

$status = $this->get_saml_status();

include(constant('SAMLTUD_AUTH_ROOT') . '/includes/views/nav_tabs.php');
include(constant('SAMLTUD_AUTH_ROOT') . '/includes/views/samltud_sp.php');
