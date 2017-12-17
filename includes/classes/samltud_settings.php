<?php

class SAML_Settings {
  private $wp_option;
  private $current_version;
  private $cache;
  private $settings;

  function __construct() {
    $this->wp_option = 'samltud_authentication_options';
    $this->current_version = '0.0.1';
    $this->cache = false;
    $this->_check_environment();
    $this->_get_settings();
  }

  /**
   * Get the "enabled" setting
   *
   * @return bool
   */
  public function get_enabled()
  {
    return (bool) $this->settings['enabled'];
  }

  public function get_idp()
  {
    return (string) $this->settings['idp'];
  }

  public function get_nameidpolicy()
  {
    return (string) $this->settings['nameidpolicy'];
  }

  /**
   * Get one of the "attribute" settings
   *
   * @param string $attribute the attribute to retrieve
   * @return string|bool The value of the attribute, or false if the attribute does not exist
   */
  public function get_attribute($attribute)
  {
    if(is_string($attribute) && array_key_exists($attribute, $this->settings['attributes']) )
    {
      return (string) $this->settings['attributes'][$attribute];
    }
    else
    {
      return false;
    }
  }

  /**
   * Get the "allow_unlisted_users" setting
   *
   * @return bool
   */
  public function get_allow_unlisted_users()
  {
    return (bool) $this->settings['allow_unlisted_users'];
  }

  /**
   * Sets whether to enable SAML authentication
   *
   * @param bool $value The new value
   * @return void
   */
  public function set_enabled($value)
  {
    if( is_bool($value) )
    {
      $this->settings['enabled'] = $value;
      $this->_set_settings();
    }
  }

  /**
   * Sets the IdP Entity ID
   *
   * @param string $value The new Entity ID
   * @return void
   */
  public function set_idp($value)
  {
    if( is_string($value) )
    {
      $this->settings['idp'] = $value;
      $this->_set_settings();
    }
  }

  /**
   * Sets the NameID Policy
   *
   * @param string $value The new NameID Policy
   * @return void
   */
  public function set_nameidpolicy($value)
  {
    $policies = array(
      'urn:oasis:names:tc:SAML:1.1:nameid-format:emailAddress',
      'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',
      'urn:oasis:names:tc:SAML:2.0:nameid-format:persistent'
    );

    if( is_string($value) && in_array($value,$policies) )
    {
      $this->settings['nameidpolicy'] = $value;
      $this->_set_settings();
    }
  }

  /**
   * Sets whether to allow unlisted_users (users with no group)
   *
   * @param bool $value The new value
   * @return void
   */
  public function set_allow_unlisted_users($value)
  {
    if( is_bool($value) )
    {
      $this->settings['allow_unlisted_users'] = $value;
      $this->_set_settings();
    }
  }

  /**
   * Sets an attribute to a new value
   *
   * @param string $attributename The array key (in $this->settings->attributes) of the attribute to change
   * @param string $value The new value for the attribute
   * @return void
   */
  public function set_attribute($attributename, $value)
  {
    if( is_string($attributename) && is_string($value) && array_key_exists($attributename,$this->settings['attributes']) )
    {
      $this->settings['attributes'][$attributename] = $value;
      $this->_set_settings();
    }
  }

  /**
   * Sets a group to a new value
   *
   * @param string $groupname The array key (in $this->settings->groups) of the group to change
   * @param string $value The new value for the group
   * @return void
   */
  public function set_group($groupname, $value)
  {
    if( is_string($groupname) && is_string($value) && array_key_exists($groupname,$this->settings['groups']) )
    {
      $this->settings['groups'][$groupname] = $value;
      $this->_set_settings();
    }
  }

  /**
   * Prevents use of ::_set_settings()
   *
   * @return void
   */
  public function enable_cache()
  {
    $this->cache = true;
  }

  /**
   * Saves settings and sets cache to false
   *
   * @return void
   */
  public function disable_cache()
  {
    $this->cache = false;
    $this->_set_settings();
  }

  /**
   * Get idp config details
   * @return array|false     array [idp_url][idp_details], false otherwise
   */
  public function get_idp_details()
  {
      return isset($this->settings['idp_details'])
              ? $this->settings['idp_details']
              : false;
  }

  /**
   * Set idp config details
   * @param array $details array [idp_url][idp_details]
   * @return void
   */
  public function set_idp_details(array $details)
  {
      $this->settings['idp_details'] = $details;
  }

  /**
   * Get the public signing key
   * @return string|false Formatted certificate, false otherwise
   */
  public function get_public_key()
  {
      return isset($this->settings['certificate']['public_key'])
              ? (string) $this->settings['certificate']['public_key']
              : false;
  }

  /**
   * Set the public signing key
   * @param string $key Formatted key
   */
  public function set_public_key($key)
  {
      $this->settings['certificate']['public_key'] = (string)$key;
  }

  /**
   * Get the private signing key
   * @return string|false Formatted key, false otherwise
   */
  public function get_private_key()
  {
      return isset($this->settings['certificate']['private_key'])
              ? (string) $this->settings['certificate']['private_key']
              : false;
  }

  /**
   * Set the private signing key
   * @param string $key Formatted key
   */
  public function set_private_key($key)
  {
      $this->settings['certificate']['private_key'] = (string)$key;
  }



	// VISITED AFTER THIS



  /**
   * Retrieves settings from the database; performs upgrades or sets defaults as necessary
   *
   * @return void
   */
  private function _get_settings() {
    $wp_option = get_option($this->wp_option);

    if( is_array($wp_option) ) {
      $this->settings = $wp_option;
      if( $this->_upgrade_settings() ) {
        $this->_set_settings();
      }
    } else {
      $this->settings = $this->_use_defaults();
      $this->_set_settings();
    }
  }

  /**
   * Writes settings to the database\
   *
   * @return bool true if settings are written to DB, false otherwise
   */
  private function _set_settings() {
    if($this->cache === false) {
      update_option($this->wp_option, $this->settings);
      return true;
    } else {
      return false;
    }
  }

  /**
   * Returns an array of default settings for the database. Typically used on first run.
   *
   * @return array the array of settings
   */
  private function _use_defaults() {
    $defaults = array(
      'option_version' => $this->current_version,
      'enabled' => false,
      'idp' => 'https://gatekeepert.tudelft.nl',
      'idp_details' =>  array(
          'https://gatekeepert.tudelft.nl' =>
          array(
            'name' => 'Gatekeeper Test',
            'SingleSignOnService' => 'https://gatekeepert.tudelft.nl/openaselect/profiles/saml2/sso/web',
            'SingleLogoutService' => 'https://gatekeepert.tudelft.nl/openaselect/profiles/saml2/sso/logout',
            'certFingerprint' => '0000000000000000000000000000000000000000',
          ),
      ),
      'certificate' =>  array(
          'public_key'  =>  '',
          'private_key' =>  ''
      ),
      'nameidpolicy' => 'urn:oasis:names:tc:SAML:2.0:nameid-format:persistent',
      'attributes' => array(
        'username' => '',
        'firstname' => '',
        'lastname' => '',
        'email' => '',
      ),
    );

    return($defaults);
  }

  /**
   * Checks for the presence of various files and directories that the plugin needs to operate
   *
   * @return void
   */
  private function _check_environment() {
		if( !file_exists( constant('SAMLTUD_AUTH_CONF') ) ) {
			mkdir( constant('SAMLTUD_AUTH_CONF'), 0775, true );
		}

		if( !file_exists( constant('SAMLTUD_AUTH_CONF') . '/certs') ) {
			mkdir( constant('SAMLTUD_AUTH_CONF') . '/certs', 0775, true );
		}
  }

  /**
   * Upgrades the settings array to the latest version
   *
   * @return bool true if changes were made, false otherwise
   */
  private function _upgrade_settings() {
    $changed = false;
    return $changed;
  }
} // End of class SAML_Settings
// End of file saml_settings.php
