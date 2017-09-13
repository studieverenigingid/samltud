# SAMLTUD (Login with NetID)

A Wordpress plugin to provide the functionality to execute SAML-logins (specifically NetID), based on [SAML 2.0 Single Sign-On](https://github.com/ktbartholomew/saml-20-single-sign-on) by [ktbartholomew](https://github.com/ktbartholomew/saml-20-single-sign-on), using [SimpleSAMLphp](https://simplesamlphp.org/).

License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

## Difference with SAML 2.0 Single Sign-On
- From [SAML 2.0 Single Sign-On](https://github.com/ktbartholomew/saml-20-single-sign-on) I’ve stripped lots of functionality (including multisite functionality, help section, adding new users, etc.)
- Added my own certificate PHP Class.
- Made the TU Delft Gatekeeper metadata the default.
- Secured the admin using a password stored in wp-config or generated onload (the original used a cryptographically insecure `uniqid()`)
- Stored the secret salt (used “when it needs to generate a secure hash of a value”) in `wp-config.php` (the original had a hard coded salt).
- The debug status is also based on WordPress’ debug status (`WP_DEBUG`) and the technical contact name on the WordPress Blog name and the email on the admin email.
- Changed the timezone.
- A newer version of SimpleSAMLphp (1.14.14 instead of 1.10.0).

## Notes on the quality
This plugin is a little hacky, mainly due to it including the entirety of SimpleSAMLphp and changing code within it. It also requires you to add a salt and password to the wp-config, while I’m not sure this is good practice.
