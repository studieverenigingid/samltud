<?php

class SAML_Client {
  private $saml;
  private $opt;

  function __construct() {
    $this->settings = new SAML_Settings();

    require_once(constant('SAMLTUD_AUTH_ROOT') . '/simplesamlphp/lib/_autoload.php');

    if( $this->settings->get_enabled() ) {
			$this->saml = new SimpleSAML_Auth_Simple('tud_dev_sp_idweb');

			add_action('wp_authenticate', array($this, 'authenticate'));
      // add_action('login_form', array($this, 'modify_login_form'));
		}
  }

  /**
   *  Authenticates the user using SAML
   *
   *  @return void
   */
  public function authenticate() {
    if( isset($_GET['loggedout']) && $_GET['loggedout'] == 'true' ) {
      // The user logged out, so redirect to the homepage.
      wp_redirect( get_home_url() );
      exit();
    } elseif ( isset($_GET['use_sso']) && $_GET['use_sso'] == 'true' ) {

      // Get the url where the IdP should redirect us to
      if (array_key_exists('redirect_to', $_GET)) {
        $redirect_url = wp_login_url( $_GET['redirect_to']);
      } else {
        $redirect_url = wp_login_url( get_home_url() );
      }

      // Append the use_sso to that url, so the request will go through this
      // function again
      $redirect_url .= '&use_sso=true';

      // Put SimpleSAML to work
      $this->saml->requireAuth( array('ReturnTo' => $redirect_url ) );

      // Get the username from the result to excecute login
      $attrs = $this->saml->getAttributes();
      $login_page = home_url( '/login' );
      if(array_key_exists($this->settings->get_attribute('username'), $attrs) ) {
        $username = $attrs[$this->settings->get_attribute('username')][0];
        if($this->get_user_by_netid($username)) {
          $this->simulate_signon($username);
        } else {
          wp_redirect($login_page . "?login=unknown_netid");
        }
      } else {
        die('A username was not provided. Please contact us.');
      }
    }
  }

  /**
   * Sends the user to the SAML Logout URL (using SLO if available) and then redirects to the site homepage
   *
   * @return void
   */
  public function logout() {
    $this->saml->logout( get_home_url() );
  }

  /**
   * Runs about halfway through the login form. If we're bypassing SSO, we need to add a field to the form
   *
   * @return void
   */
  // Probably not needed because it put everything in the get parameters //out
  // public function modify_login_form() {
  //   if ( array_key_exists('use_sso', $_GET) && $_GET['use_sso'] == 'true' ) {
  //     echo '<input type="hidden" name="use_sso" value="true">' . "\n";
  //   }
  // }

  /**
   * Authenticates the user with WordPress using wp_signon()
   *
   * @param string $username The user to log in as.
   * @return void
   */
  private function simulate_signon($username) {
    $user = $this->get_user_by_netid($username);
    wp_set_auth_cookie($user->ID);

    if( array_key_exists('redirect_to', $_GET) ) {
      wp_redirect( $_GET['redirect_to'] );
    } else {
      wp_redirect(get_home_url());
    }
    exit();
  }

  private function get_user_by_netid($username) {
    $args = array(
      'meta_key' => 'svid_netid',
      'meta_value' => $username,
      'number' => 1
    );
    $users = get_users($args);
    return $users[0];
  }

} // End of class SAML_Client
