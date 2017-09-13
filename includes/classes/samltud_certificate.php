<?php

class SAMLTUD_certificate {

  public $pkey;
  public $cert;

  public function __construct() {
    $upload_dir = constant('SAMLTUD_AUTH_CONF') . '/certs/tud_dev_sp_idweb';

    if ( !$this->find_certificate() ) {
      $this->inform('Certificate not found at <code>' . $upload_dir . 'sp.pem</code>; generating certificate.', 'warning');
      $generation = $this->generate_certificate();
      if ( $generation['success'] ) {
        $this->inform('Construct of <code>SAMLTUD_certificate</code> finished.');
      } else {
        $this->inform('Construct of <code>SAMLTUD_certificate</code> failed.', 'error');
      }
      // make the attributes of this class the files for the key and certificate
      $this->pkey = $generation['pkey'];
      $this->cert = $generation['cert'];
    } else {
      $this->inform('Construct of <code>SAMLTUD_certificate</code> finished; certificate already existed.');
    }

  }



  /**
	 * Check for the openssl configuration file
   * @param (string|bool) $override a different path from the default to check
   * @return (bool) if there is a configuration file
	 */
  private function check_for_openssl_conf( $override=false ) {

    if ( $override ) {
      if ( $this->is_openssl_conf_usable( $override ) ) {
        $this->inform('Using the configuration file at <code>' . $override . '</code>');
        return true;
      } else {
        return false;
      }
    }

    // This won’t actually happen anymore, because in `generate_certificate()`
    // a config path is defined and used as override, but it could pay off to
    // let this functionality exist (idk just lazy)
    if ( defined('OPENSSL_CONF') ) {
      if ( $this->is_openssl_conf_usable( OPENSSL_CONF ) ) {
        $this->inform('Using the configuration file at <code>' . OPENSSL_CONF . '</code>');
        return true;
      } else {
        return false;
      }
    } else {
      $this->inform('<code>OPENSSL_CONF</code> was not defined in your wp-config.php, please do.', 'error');
      return false;
    }

  }



  /**
	 * Check if the openssl configuration file is usable
   * @param (string) $conf_path the file path to check
   * @return (bool) if there is a usable configuration file
	 */
  private function is_openssl_conf_usable( $conf_path ) {
    if ( file_exists($conf_path) ) {
      return $this->is_openssl_conf_readable($conf_path);
    } else {
      $this->inform('The configuration file at <code>'.$conf_path.'</code> doesn’t seem to exist.', 'error');
      return false;
    }
  }



  /**
	 * Check if the openssl configuration file is readable
   * @param (string) $conf_path the file path to check
   * @return (bool) if there is a readable configuration file at $conf_path
	 */
  private function is_openssl_conf_readable( $conf_path ) {
    if ( is_readable($conf_path) ) {
      return true;
    } else {
      $this->inform('The <code>openssl.cnf</code> is not readable by the UNIX user.', 'error');
      return false;
    }
  }



  /**
	 * Check if path is wrtiable, notify the user otherwise
   * @param (string) $test_path the path to check
   * @return (bool) if it is writable
	 */
  private function is_path_writable( $test_path ) {
    if ( is_writable($test_path) ) {
      return true;
    } else {
      $this->inform('The path <code>' . $test_path . '</code> is not writable by the UNIX user.', 'error');
      return false;
    }
  }



  /**
	 * Check if the openssl configuration file is usable
   * @return (bool) if there is a usable configuration file
	 */
  private function generate_certificate() {

    $config_path = plugin_dir_path(__FILE__) . 'openssl.cnf';
    $upload_dir = constant('SAMLTUD_AUTH_CONF') . '/certs/tud_dev_sp_idweb';

    if ( !$this->check_for_openssl_conf($config_path) ) {
      return false;
    }

    if ( !$this->is_path_writable($upload_dir) ) {
      return false;
    }

    $config_args = array(
      'config' => $config_path,
      'digest_alg' => 'sha265',
      'x509_extensions' => 'v3_ca',
      'req_extensions'   => 'v3_req',
      'private_key_bits' => 2048,
      'private_key_type' => OPENSSL_KEYTYPE_RSA,
      'encrypt_key' => false,
    );

    $private_key = openssl_pkey_new($config_args);

    $dn = array(
      "countryName" => "NL",
      "stateOrProvinceName" => "Zuid-Holland",
      "localityName" => "Delft",
      "organizationName" => "Studievereniging i.d",
      "emailAddress" => get_option('admin_email')
    );

    $csr = openssl_csr_new($dn, $private_key, $config_args);

    $serial_length = pow(10,8);
    $serial_no = random_int($serial_length, $serial_length * 9);
    $this->inform($serial_no);

    // Generate certificate
    $sscert = openssl_csr_sign($csr, null, $private_key, 365, $config_args, $serial_no);

    // Show any errors that occurred here
    // while (($e = openssl_error_string()) !== false) {
      //$this->inform($e, 'warning');
    // }

    $pkey_file = null;
    $pkey_export = openssl_pkey_export($private_key, $pkey_file, null, $config_args);
    if (!$pkey_export) $this->inform('Private key writing to variable failed.', 'error');

    $cert_file = null;
    $cert_export = openssl_x509_export($sscert, $cert_file);
    if (!$cert_export) $this->inform('Certificate writing to variable failed.', 'error');

    if (!$pkey_export || !$cert_export) return false;

    $pkey_to_file = file_put_contents($upload_dir.'sp.pem', $pkey_file . PHP_EOL, FILE_APPEND);
    if (!$pkey_to_file) $this->inform('Private key writing to file failed.', 'error');
    $cert_to_file = file_put_contents($upload_dir.'sp.pem', $cert_file . PHP_EOL, FILE_APPEND);
    if (!$cert_to_file) $this->inform('Private key writing to file failed.', 'error');

    $return = array(
      'success' => $pkey_to_file && $cert_to_file,
      'pkey' => $pkey_file,
      'cert' => $cert_file,
    );

    return $return;

  }



  /**
	 * Check if there already is a certificate
   * @return (bool) certificate
	 */
  private function find_certificate() {
    $upload_dir = constant('SAMLTUD_AUTH_CONF') . '/certs/tud_dev_sp_idweb';
    return file_exists($upload_dir.'sp.pem');
  }



  /**
	 * Inform the user through a hacked together WP notice
   * @param (string) $message the message to display to the user
   * @param [(string) $type] the type of container the message should be
   *    displayed in; could be info, warning, error or success
   * @return (void)
	 */
  private function inform( $message, $type='info' ) {
    echo '<div class="notice notice-' . $type . '">';
    echo '<p>' . $message . '</p>';
    echo '</div>';
  }

}
