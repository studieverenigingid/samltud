<?php

$wp_opt = get_option('samltud_authentication_options');

$idp_file = constant('SAMLTUD_AUTH_CONF') . '/config/saml20-idp-remote.ini';

/*
 * Check database for idp detail configuration,
 * if not found, check for flat file configuration
 * otherwise, use empty config
 */
if (isset($wp_opt['idp_details'])) {
  $details = array_keys($wp_opt['idp_details']);
  $idp = $details[0];
} elseif (file_exists($idp_file)) {
  $details = array_keys(parse_ini_file($idp_file ,true));
  $idp = $details[0];
} else {
  $idp = NULL;
}


$config = array(

    // This is a authentication source which handles admin authentication.
    'admin' => array(
        // The default is to use core:AdminPassword, but it can be replaced with
        // any authentication source.

        'core:AdminPassword',
    ),


    // An authentication source which can authenticate against both SAML 2.0
    // and Shibboleth 1.3 IdPs.
    'tud_dev_sp_idweb' => array(
        'saml:SP',

        'NameIDPolicy' => $wp_opt['nameidpolicy'],
        // The entity ID of this SP.
        // Can be NULL/unset, in which case an entity ID is generated based on the metadata URL.
        'entityID' => null,

        'sign.authnrequest' => true,
        'sign.logout' => true,
        'redirect.sign' => true,

        // The entity ID of the IdP this should SP should contact.
        // Can be NULL/unset, in which case the user will be shown a list of available IdPs.
        // 'idp' => null,
        'idp' => $idp,

        // The URL to the discovery service.
        // Can be NULL/unset, in which case a builtin discovery service will be used.
        // 'discoURL' => null,
        // 'privatekey' => 'sp.pem',
        // 'certificate' => 'sp.pem',
        // 'metadata.sign.enable' => TRUE,

        /*
         * WARNING: SHA-1 is disallowed starting January the 1st, 2014.
         *
         * Uncomment the following option to start using SHA-256 for your signatures.
         * Currently, SimpleSAMLphp defaults to SHA-1, which has been deprecated since
         * 2011, and will be disallowed by NIST as of 2014. Please refer to the following
         * document for more information:
         *
         * http://csrc.nist.gov/publications/nistpubs/800-131A/sp800-131A.pdf
         *
         * If you are uncertain about identity providers supporting SHA-256 or other
         * algorithms of the SHA-2 family, you can configure it individually in the
         * IdP-remote metadata set for those that support it. Once you are certain that
         * all your configured IdPs support SHA-2, you can safely remove the configuration
         * options in the IdP-remote metadata set and uncomment the following option.
         *
         * Please refer to the hosted SP configuration reference for more information.
          */
        // 'signature.algorithm' => 'http://www.w3.org/2001/04/xmldsig-more#rsa-sha256',

        /*
         * The attributes parameter must contain an array of desired attributes by the SP.
         * The attributes can be expressed as an array of names or as an associative array
         * in the form of 'friendlyName' => 'name'.
         * The metadata will then be created as follows:
         * <md:RequestedAttribute FriendlyName="friendlyName" Name="name" />
         */
        /*'attributes' => array(
            'attrname' => 'urn:oid:x.x.x.x',
        ),*/
        /*'attributes.required' => array (
            'urn:oid:x.x.x.x',
        ),*/
    ),

);

// Cert and Key may not exist,
// check database then for flat files
if (isset($wp_opt['certificate']['public_key'])) {
  $certificate = $wp_opt['certificate']['public_key'];
  $removedCertTag = str_replace('CERTIFICATE-----', '', $certificate);
  $removedBeginTag = str_replace('-----BEGIN', '', $removedCertTag);
  $noTags = str_replace('-----END', '', $removedBeginTag);
  $config['tud_dev_sp_idweb']['certData'] = trim($noTags);
} elseif (file_exists( constant('SAMLTUD_AUTH_CONF') . '/certs/tud_dev_sp_idweb/tud_dev_sp_idweb.cer') ) {
	$config['tud_dev_sp_idweb']['certificate'] = constant('SAMLTUD_AUTH_CONF') . '/certs/tud_dev_sp_idweb/tud_dev_sp_idweb.cer';
}

// Set key paths
$upload_dir = constant('SAMLTUD_AUTH_CONF') . '/certs/tud_dev_sp_idweb';
$keyPath = $upload_dir . '/tud_dev_sp_idweb.key';

// If key information is found in database,
// but keyfile doesn't exist, create it
// otherwise, check if keyfile exists
if ( isset($wp_opt['certificate']['private_key'])
  && !file_exists($keyPath) ) {
  // Create all parent directories to store private key
  if( !is_dir($upload_dir)) {
    mkdir($upload_dir, 0775, true);
  }

  if ( file_put_contents($keyPath, $wp_opt['certificate']['private_key']) ) {
    $config['tud_dev_sp_idweb']['privatekey'] = $keyPath;
  }
} elseif( file_exists($keyPath)) {
	$config['tud_dev_sp_idweb']['privatekey'] = $keyPath;
}

return $config;
