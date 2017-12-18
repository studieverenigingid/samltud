<?php

class SAMLTUD_admin {

	private $settings;

	public function __construct() {
		add_action('admin_menu', array($this, 'add_plugin_pages'));

		$this->settings = new SAML_Settings();

		add_filter( 'plugin_action_links_'.SAMLTUD_PLUGIN_NAME,
			array($this, 'plugin_add_settings_link') );
	}

	public function add_plugin_pages() {

		add_submenu_page(
			'options-general.php',
			'SAMLTUD - Login with NetID', // page name
			'SAMLTUD', // menu item name
			'manage_options', // capability required
			'samltud_general.php', // menu slug
			array($this, 'samltud_general') // function to show the page
		);

		add_submenu_page(
			'options-general.php',
			'SAMLTUD - Login with NetID', // page name
			'SAMLTUD', // menu item name
			'manage_options', // capability required
			'samltud_sp.php', // menu slug
			array($this, 'samltud_sp') // function to show the page
		);

		add_submenu_page(
			'options-general.php',
			'SAMLTUD - Login with NetID', // page name
			'SAMLTUD', // menu item name
			'manage_options', // capability required
			'samltud_idp.php', // menu slug
			array($this, 'samltud_idp') // function to show the page
		);

		remove_submenu_page( 'options-general.php', 'samltud_sp.php' );
		remove_submenu_page( 'options-general.php', 'samltud_idp.php' );

	}

	/**
   * Get identity provider details
   * @return array
   */
  private function _get_idp_details() {
    $config_path = constant('SAMLTUD_AUTH_CONF') . '/config/saml20-idp-remote.ini';
    $idp_details = null;
    $idp_settings = $this->settings->get_idp_details();

    /*
     Read configuration details from database, if none is available,
     check for a configuration file, otherwise use default values.
     */
    if ($idp_settings) {
      $idp_details = $idp_settings;
    } elseif (file_exists($config_path)) {
      $idp_details = parse_ini_file($config_path, true);
    } else {
      $idp_details = array(
        'https://your-idp.net' =>
          array(
            'name' => 'Your IdP',
            'SingleSignOnService' => 'https://your-idp.net/SSOService',
            'SingleLogoutService' => 'https://your-idp.net/SingleLogoutService',
            'certFingerprint' => '0000000000000000000000000000000000000000',
          ),
      );
    }

    return $idp_details;
  }


	/*
  * Function Get SAML Status
  *   Evaluates SAML configuration for basic sanity
  *
  *
  * @param void
  *
  * @return Object
  */
  public function get_saml_status() {
    $return = new stdClass;
    $return->html = "";
    $return->num_warnings = 0;
    $return->num_errors = 0;

    $status = array(
      'idp_entityid' => array(
        'error_default' => 'You have not changed your IdP&rsquo;s Entity ID from the default value. You should update it to a real value.',
        'error_blank'   => 'You have not provided an Entity ID for your IdP.',
        'warning'       => 'The Entity ID you provided may not be a accessible (perhaps a bad URL). You should check that it is correct.',
        'ok'            => 'You have provided an Entity ID for your IdP.',
      ),
      'idp_sso' => array(
        'error'   => 'You have not changed your IdP&rsquo;s Single Sign-On URL from the default value. You should update it to a real value.',
        'warning' => 'You have not provided a Single Sign-On URL for your IdP. Users will have to log in using the <a href="?page=sso_help.php#idp-first-flow">IdP-first flow</a>.',
        'ok'      => 'You have provided a Single Sign-On URL for your IdP.',
      ),
      'idp_slo' => array(
        'error'   => 'You have not changed your IdP&rsquo;s Single Logout URL from the default value. You should update it to a real value.',
        'warning' => 'You have not provided a Single Logout URL for your IdP. Users will not be logged out of the IdP when logging out of your site.',
        'ok'      => 'You have provided a Single Logout URL for your IdP.',
      ),
      'idp_fingerprint' => array(
        'error'   => 'You have not provided a Certificate Fingerprint for your IdP',
        'warning' => '',
        'ok'      => 'You have provided a Certificate Fingerprint for your IdP.',
      ),
      'sp_certificate' => array(
        'error'   => '',
        'warning' => 'You have not provided a Certificate or Private Key for this site. Users may not be able to log in using the SP-first flow.',
        'ok'      => 'You have provided a Certificate and Private Key for this site.',
      ),
      'sp_attributes' => array(
        'error'   => 'You have not provided the neccessary SAML attributes to allow users to log in. You must <strong>at least</strong> specify SAML attributes to be used for the "username" field.',
        'warning' => 'You have not provided SAML attributes for all fields. Users may be able to log in, but may not have all attributes such as first and last name.',
        'ok'      => 'You have provided SAML attributes for all user fields.',
      ),
			'samltud_salt' => array(
				'error'		=> 'You have not defined a SAMLTUD_SALT in your wp-config.php, please do (and generate one on https://api.wordpress.org/secret-key/1.1/salt/).',
				'warning'	=> '-',
				'ok'			=> 'You have defined a SAMLTUD_SALT in your wp-config.php.',
			),
			'samltud_pwd' => array(
				'error'		=> 'You have not defined a SAMLTUD_PWD in your wp-config.php, please do.',
				'warning'	=> '-',
				'ok'			=> 'You have defined a SAMLTUD_PWD in your wp-config.php.',
			),
    );

    $status_html = array(
      'error' => array(
        '<tr class="red"><td><i class="icon-remove icon-large"></i></td><td>',
        '</td></tr>'
      ),
      'warning' => array(
        '<tr class="yellow"><td><i class="icon-warning-sign icon-large"></i></td><td>',
        '</td></tr>'
      ),
      'ok' => array(
        '<tr class="green"><td><i class="icon-ok icon-large"></i></td><td>',
        '</td></tr>'
      )
    );

    $idp_ini = $this->_get_idp_details();
    $return->html .= '<table class="saml_status">'."\n";

    if (is_array($idp_ini)) {
      foreach($idp_ini as $key => $val) {
        if ( trim($key) != '' && $key != 'https://your-idp.net') {
          //$return->html .= $status_html['ok'][0] . $status['idp_entityid']['ok'] . $status_html['ok'][1];
        } elseif ( trim($key) == 'https://your-idp.net') {
          $return->html .= $status_html['error'][0] . $status['idp_entityid']['error_default'] . $status_html['ok'][1];
          $return->num_errors++;
        } elseif ($key == '') {
          $return->html .= $status_html['error'][0] . $status['idp_entityid']['error_blank'] . $status_html['ok'][1];
          $return->num_errors++;
        }

        if ( $val['SingleSignOnService'] == 'https://your-idp.net/SSOService' ) {
          $return->html .= $status_html['error'][0] . $status['idp_sso']['error'] . $status_html['error'][1];
        } elseif ( trim( $val['SingleSignOnService'] ) != '') {
          //$return->html .= $status_html['ok'][0] . $status['idp_sso']['ok'] . $status_html['ok'][1];
        } else {
          $return->html .= $status_html['warning'][0] . $status['idp_sso']['warning'] . $status_html['warning'][1];
        }

        if ( $val['SingleLogoutService'] == 'https://your-idp.net/SingleLogoutService' ) {
          $return->html .= $status_html['error'][0] . $status['idp_slo']['error'] . $status_html['error'][1];
          $return->num_errors++;
        } elseif ( trim( $val['SingleLogoutService'] ) != '') {
          //$return->html .= $status_html['ok'][0] . $status['idp_slo']['ok'] . $status_html['ok'][1];
        } else {
          $return->html .= $status_html['warning'][0] . $status['idp_slo']['warning'] . $status_html['warning'][1];
        }

        if ( $val['certFingerprint'] != '0000000000000000000000000000000000000000' && $val['certFingerprint'] != '') {
          //$return->html .= $status_html['ok'][0] . $status['idp_fingerprint']['ok'] . $status_html['ok'][1];
        } else {
          $return->html .= $status_html['error'][0] . $status['idp_fingerprint']['error'] . $status_html['ok'][1];
          $return->num_errors++;
        }
      }
    }

    /*
     * Check if public and private keys are set in the database config
     * otherwise check for cert files.
     */
    $certPath = constant('SAMLTUD_AUTH_CONF') . '/certs/' . constant('SAMLTUD_SLUG') . '/' . constant('SAMLTUD_SLUG');
    $hasKeysInDb = ($this->settings->get_public_key() && $this->settings->get_private_key());
    $keyFilesExist = (file_exists($certPath. '.cer') && file_exists($certPath. '.key'));

    if ($hasKeysInDb || $keyFilesExist) {
      //$return->html .= $status_html['ok'][0] . $status['sp_certificate']['ok'] . $status_html['ok'][1];
    } else {
      $return->html .= $status_html['warning'][0] . $status['sp_certificate']['warning'] . $status_html['warning'][1];
    }

    if ( trim($this->settings->get_attribute('username')) == '' ) {
      $return->html .= $status_html['error'][0] . $status['sp_attributes']['error'] . $status_html['error'][1];
      $return->num_errors++;
    } elseif ( trim ($this->settings->get_attribute('firstname')) == '' || trim ($this->settings->get_attribute('lastname')) == '' || trim ($this->settings->get_attribute('email')) == '') {
      $return->html .= $status_html['warning'][0] . $status['sp_attributes']['warning'] . $status_html['warning'][1];
    } else {
      //$return->html .= $status_html['ok'][0] . $status['sp_attributes']['ok'] . $status_html['ok'][1];
    }

		if ( !defined('SAMLTUD_SALT') ) {
			$return->html .= $status_html['error'][0] . $status['samltud_salt']['error'] . $status_html['error'][1];
			$return->num_errors++;
		} else {
			//$return->html .= $status_html['ok'][0] . $status['samltud_salt']['ok'] . $status_html['ok'][1];
		}

		if ( !defined('SAMLTUD_PWD') ) {
			$return->html .= $status_html['error'][0] . $status['samltud_pwd']['error'] . $status_html['error'][1];
			$return->num_errors++;
		} else {
			//$return->html .= $status_html['ok'][0] . $status['samltud_salt']['ok'] . $status_html['ok'][1];
		}

    $return->html .= '</table>'."\n";

    return $return;
  }

	public function samltud_general() {
    include constant('SAMLTUD_AUTH_ROOT') . '/includes/controllers/' . __FUNCTION__ . '.php';
  }

  public function samltud_idp() {
    include constant('SAMLTUD_AUTH_ROOT') . '/includes/controllers/' . __FUNCTION__ . '.php';
  }

  public function samltud_sp() {
    include constant('SAMLTUD_AUTH_ROOT') . '/includes/controllers/' . __FUNCTION__ . '.php';
  }



	/**
	 * Options page callback
	 */
	/*
	public function create_admin_page() {
		// Set class property
		$this->options = get_option(WP_OPTION_NAME);
		?>
		<div class="wrap">
			<h2>SAMLTUD (login with NetID)</h2>

			<form method="post" action="options.php">
				<?php
				This prints out all hidden setting fields
				settings_fields('default_settings');
				require_once plugin_dir_path(__FILE__) . 'classamltud_certificate.php';
				$cert = new SAMLTUD_certificate();
				submit_button();
				?>
			</form>
		</div>
		<?php
	}
	*/



	public function plugin_add_settings_link( $links ) {
    $settings_link = "<a href='options-general.php?page=samltud_general.php'>" . __( 'Settings' ) . "</a>";
    array_unshift( $links, $settings_link );
  	return $links;
	}



}
