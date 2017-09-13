<?php
/**
 * SAML 2.0 remote IdP metadata for SimpleSAMLphp.
 *
 * Remember to remove the IdPs you don't use from this file.
 *
 * See: https://simplesamlphp.org/docs/stable/simplesamlphp-reference-idp-remote
 */

/*
 * Guest IdP. allows users to sign up and register. Great for testing!
 */
$metadata['https://openidp.feide.no'] = array(
	'name' => array(
		'en' => 'Feide OpenIdP - guest users',
		'no' => 'Feide Gjestebrukere',
	),
	'description'          => 'Here you can login with your account on Feide RnD OpenID. If you do not already have an account on this identity provider, you can create a new one by following the create new account link and follow the instructions.',

	'SingleSignOnService'  => 'https://openidp.feide.no/simplesaml/saml2/idp/SSOService.php',
	'SingleLogoutService'  => 'https://openidp.feide.no/simplesaml/saml2/idp/SingleLogoutService.php',
	'certFingerprint'      => 'c9ed4dfb07caf13fc21e0fec1572047eb8a7a4cb'
);

// Gatekeeper T, the test IdP
$metadata['gatekeepert.tudelft.nl'] = array (
  'entityid' => 'gatekeepert.tudelft.nl',
  'contacts' =>
  array (
  ),
  'metadata-set' => 'saml20-idp-remote',
  'sign.authnrequest' => true,
  'SingleSignOnService' =>
  array (
    0 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
      'Location' => 'https://gatekeepert.tudelft.nl/openaselect/profiles/saml2/sso/web',
    ),
    1 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
      'Location' => 'https://gatekeepert.tudelft.nl/openaselect/profiles/saml2/sso/web',
    ),
    2 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Artifact',
      'Location' => 'https://gatekeepert.tudelft.nl/openaselect/profiles/saml2/sso/web',
    ),
  ),
  'SingleLogoutService' =>
  array (
    0 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
      'Location' => 'https://gatekeepert.tudelft.nl/openaselect/profiles/saml2/sso/logout',
    ),
    1 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
      'Location' => 'https://gatekeepert.tudelft.nl/openaselect/profiles/saml2/sso/logout',
    ),
    2 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Artifact',
      'Location' => 'https://gatekeepert.tudelft.nl/openaselect/profiles/saml2/sso/logout',
    ),
    3 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:SOAP',
      'Location' => 'https://gatekeepert.tudelft.nl/openaselect/profiles/saml2/sso/logout',
    ),
  ),
  'ArtifactResolutionService' =>
  array (
    0 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:SOAP',
      'Location' => 'https://gatekeepert.tudelft.nl/openaselect/profiles/saml2/ArtifactResolution',
      'index' => 0,
    ),
  ),
  'NameIDFormats' =>
  array (
    0 => 'urn:oasis:names:tc:SAML:2.0:nameid-format:persistent',
    1 => 'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',
    2 => 'urn:oasis:names:tc:SAML:1.1:nameid-format:unspecified',
  ),
  'keys' =>
  array (
    0 =>
    array (
      'encryption' => false,
      'signing' => true,
      'type' => 'X509Certificate',
      'X509Certificate' => 'MIIDZDCCAkygAwIBAgIEVmUtUzANBgkqhkiG9w0BAQUFADB0MQswCQYDVQQGEwJOTDEVMBMGA1UE
CBMMWnVpZCBIb2xsYW5kMQ4wDAYDVQQHEwVEZWxmdDERMA8GA1UEChMIVFUgRGVsZnQxEDAOBgNV
BAsTB1NTQy1JQ1QxGTAXBgNVBAMTEHR1ZGFzZWxlY3RzaWduZWQwHhcNMTUxMjA3MDY1NTE1WhcN
MTYxMjA2MDY1NTE1WjB0MQswCQYDVQQGEwJOTDEVMBMGA1UECBMMWnVpZCBIb2xsYW5kMQ4wDAYD
VQQHEwVEZWxmdDERMA8GA1UEChMIVFUgRGVsZnQxEDAOBgNVBAsTB1NTQy1JQ1QxGTAXBgNVBAMT
EHR1ZGFzZWxlY3RzaWduZWQwggEiMA0GCSqGSIb3DQEBAQUAA4IBDwAwggEKAoIBAQCEb5v1jbv5
YKw8G48UNWS+dBg5AvWesqMdgoDm8Qz0b4ixhfRhLasdqjvpbw/yp/nnxgOQTDrBSYQCawi2gOz3
9pZSnjyL4IB/Pc/JfMobH00ZIqvg8P0UgtZcsG/thHUh8wyJQcRvGNhtTjETK8w0ZxRI1duA8oIn
AHjxNppJpiOgetOvPjCxx5Gm7HkyVmRTvqiD0Lrag46aFcUsC1byXW7TyRJmC8jyLMlWPqEg5WM2
BytmDVgeyww3hBsZl6JcRt98Ic7XL7X0xm7UBdqkakmTR0Pc7DIC+SIeMmicX5qqas4vb3qpljvz
NQnOYdtVTvgNn+Mjs8aoF47YFCYjAgMBAAEwDQYJKoZIhvcNAQEFBQADggEBAD2Tm7304BLLtqYb
iR17VefQq7n3ESHDjsIBHn6nP698AOMb6+nkwwb1BK+X0o1p/IuPm3ry9Ar0x7bRAIwfajeXHPeb
VkAPvr/u167CzRZleVpsx0dwZzDxSHTJAZIlRkDImvbwpdW+p6OjJZa09D6QnYvkGdM0hWPShZY6
x3kOZ+Z7uVGe74eTMLzPg4wvHmTF4bZipCGj6Nc+yZAJPNcuC4106XdBbh+/MEZF1yZoBgjsi+5r
7GG14tcQan4fMjjqP5PW3TWsZJF710LRZVZ4ePQuypnJlly871ODSzjg3yfhAWLhOajZjQALsIBQ
MFBnBkbf8q9HFaPWuGqKD0s=',
    ),
  ),
);


// Gatekeeper 2, the production IdP
$metadata['https://gatekeeper2.tudelft.nl/openaselect/profiles/saml2/'] = array (
  'entityid' => 'https://gatekeeper2.tudelft.nl/openaselect/profiles/saml2/',
  'contacts' =>
  array (
  ),
  'metadata-set' => 'saml20-idp-remote',
  'sign.authnrequest' => true,
  'SingleSignOnService' =>
  array (
    0 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
      'Location' => 'https://gatekeeper2.tudelft.nl/openaselect/profiles/saml2/sso/web',
    ),
    1 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
      'Location' => 'https://gatekeeper2.tudelft.nl/openaselect/profiles/saml2/sso/web',
    ),
    2 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Artifact',
      'Location' => 'https://gatekeeper2.tudelft.nl/openaselect/profiles/saml2/sso/web',
    ),
  ),
  'SingleLogoutService' =>
  array (
    0 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
      'Location' => 'https://gatekeeper2.tudelft.nl/openaselect/profiles/saml2/sso/logout',
    ),
    1 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
      'Location' => 'https://gatekeeper2.tudelft.nl/openaselect/profiles/saml2/sso/logout',
    ),
    2 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Artifact',
      'Location' => 'https://gatekeeper2.tudelft.nl/openaselect/profiles/saml2/sso/logout',
    ),
    3 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:SOAP',
      'Location' => 'https://gatekeeper2.tudelft.nl/openaselect/profiles/saml2/sso/logout',
    ),
  ),
  'ArtifactResolutionService' =>
  array (
    0 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:SOAP',
      'Location' => 'https://gatekeeper2.tudelft.nl/openaselect/profiles/saml2/ArtifactResolution',
      'index' => 0,
    ),
  ),
  'NameIDFormats' =>
  array (
    0 => 'urn:oasis:names:tc:SAML:2.0:nameid-format:persistent',
    1 => 'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',
    2 => 'urn:oasis:names:tc:SAML:1.1:nameid-format:unspecified',
  ),
  'keys' =>
  array (
    0 =>
    array (
      'encryption' => false,
      'signing' => true,
      'type' => 'X509Certificate',
      'X509Certificate' => 'MIIDhzCCAm+gAwIBAgIEfRjvpzANBgkqhkiG9w0BAQsFADB0MQswCQYDVQQGEwJOTDEVMBMGA1UE
CBMMWnVpZC1Ib2xsYW5kMQ4wDAYDVQQHEwVEZWxmdDERMA8GA1UEChMIVFUgRGVsZnQxEDAOBgNV
BAsTB1NTQy1JQ1QxGTAXBgNVBAMTEHR1ZGFzZWxlY3RzaWduZWQwHhcNMTYwMjAxMTAyMjQ0WhcN
MjYwMTI5MTAyMjQ0WjB0MQswCQYDVQQGEwJOTDEVMBMGA1UECBMMWnVpZC1Ib2xsYW5kMQ4wDAYD
VQQHEwVEZWxmdDERMA8GA1UEChMIVFUgRGVsZnQxEDAOBgNVBAsTB1NTQy1JQ1QxGTAXBgNVBAMT
EHR1ZGFzZWxlY3RzaWduZWQwggEiMA0GCSqGSIb3DQEBAQUAA4IBDwAwggEKAoIBAQDBT4QL8BWh
dKIpNQFFfwk9T9/5z+sI8MLvxUuIkdpi+LOxvrPqhfM80FNaYGOY+LUOCHe9YW3Xez9MY1k2rcT8
J3YAyosXgKoha5lbGf59ZMdjA9+KciJdIQ9O2+NF5xai72OCuTsfPN1RZT8JqP8WtoHAKsrMXZbX
toE7XVTGXYvwE2aU25tW9JiDb3ZEvJibmGHKS7EDL5uau0DmTYoNQZE76jErdPl3idSNBuk5PBnJ
4hV1NqWfAiDYb1oVkpQath2zBVSUoMNhNis3bmQdCFHzruVrX8ClhGEPurnxtxGgTbudmbXM4CF3
w1izasUJCAq/vNvM65rQ7p5qL8hVAgMBAAGjITAfMB0GA1UdDgQWBBSUqH9CcXmKnfNLTCaUksq2
Qg2agzANBgkqhkiG9w0BAQsFAAOCAQEATTh4nDSYAiU0TEl6DNCis9BH99lBLaIg2rciYawQKgQZ
aPhwCtBxOPy56fMcJc/cg34UiUkKtiIdmwilLBim3aZlVNKOKpZOm54B7IXxxM0VflRWvG6r5d/e
33mZmmSFMMwK7duKF8W5tyNA56wznczNkTV9H6xOdYJO0lc2Pq7Vs+zJx7pb7YEz0ibwrTofM5eP
koKMMApW7xlZxgWr0Cw+q/+hN5m3uTa1MT478FJ2cy7aEJRRIRl7VwRidD4Fodd4HZx+zlbfKOk6
+9KazDUS7qIoqx3QsCn1CmOG2ymoTEMD6I4fSiiOCLmBvk7meTrYuyyI+W11s1W41hNPqg==',
    ),
  ),
);

$metadata['urn:example:idp'] = array (
  'entityid' => 'urn:example:idp',
  'contacts' =>
  array (
  ),
  'metadata-set' => 'saml20-idp-remote',
  'SingleSignOnService' =>
  array (
    0 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
      'Location' => 'http://localhost:7000',
    ),
    1 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
      'Location' => 'http://localhost:7000',
    ),
  ),
  'SingleLogoutService' =>
  array (
    0 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
      'Location' => 'http://localhost:7000/logout',
    ),
  ),
  'ArtifactResolutionService' =>
  array (
  ),
  'NameIDFormats' =>
  array (
    0 => 'urn:oasis:names:tc:SAML:1.1:nameid-format:emailAddress',
    1 => 'urn:oasis:names:tc:SAML:2.0:nameid-format:persistent',
    2 => 'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',
  ),
  'keys' =>
  array (
    0 =>
    array (
      'encryption' => false,
      'signing' => true,
      'type' => 'X509Certificate',
      'X509Certificate' => '
MIIEMDCCAxigAwIBAgIJAIdOH5XLdBHfMA0GCSqGSIb3DQEBBQUAMG0xCzAJBgNVBAYTAlVTMRMwEQYDVQQIEwpDYWxpZm9ybmlhMRYwFAYDVQQHEw1TYW4gRnJhbmNpc2NvMRAwDgYDVQQKEwdKYW5reUNvMR8wHQYDVQQDExZUZXN0IElkZW50aXR5IFByb3ZpZGVyMB4XDTE3MDgwMjIwNDcyMFoXDTM3MDcyODIwNDcyMFowbTELMAkGA1UEBhMCVVMxEzARBgNVBAgTCkNhbGlmb3JuaWExFjAUBgNVBAcTDVNhbiBGcmFuY2lzY28xEDAOBgNVBAoTB0phbmt5Q28xHzAdBgNVBAMTFlRlc3QgSWRlbnRpdHkgUHJvdmlkZXIwggEiMA0GCSqGSIb3DQEBAQUAA4IBDwAwggEKAoIBAQDRRS+XK4c0gmM2EkzIHBaIgeBVMf9lf7HP3hpW4mOWdz9drt8K3tMoFB6FEvVyrfSztf5puLa+f6XTexp+ihjwJc0f4KJyd3aGN1hOTbHaILL1k+45UYsyq1cA/lZvhczlNnrSEo0mjHSi/W2TEtfvNBLm6ap3ui8XI2jEYC66QQ4ATTJeydXnt4wq40js++R9iLjpA60/UeTG8eLbtf5urMVog5bgcx0fMHdSp6zYa4rUybiN/FIOcvJACcSJgoZow5Wv2OpbkLWiZKo6qssAEcHsnourE4GJj7KUBqIrgHBtHkhTw+1Ul8YZESfPYvFR19m2R43C8HXo6CDb8NjFAgMBAAGjgdIwgc8wHQYDVR0OBBYEFAkCxtijiC0qsgGBdQv6sctwwm0SMIGfBgNVHSMEgZcwgZSAFAkCxtijiC0qsgGBdQv6sctwwm0SoXGkbzBtMQswCQYDVQQGEwJVUzETMBEGA1UECBMKQ2FsaWZvcm5pYTEWMBQGA1UEBxMNU2FuIEZyYW5jaXNjbzEQMA4GA1UEChMHSmFua3lDbzEfMB0GA1UEAxMWVGVzdCBJZGVudGl0eSBQcm92aWRlcoIJAIdOH5XLdBHfMAwGA1UdEwQFMAMBAf8wDQYJKoZIhvcNAQEFBQADggEBAK6OpMH4HYamezZvhPqrGgTG2wa+54hWU/EHoSB5al36cMt0eeuvcDtsQyVfX5Npd1OvOZdOR9AMH6Y4hyOUZgAZ/u3YShvG8YfaSRxFe1EAwQsA52w8qSkKDp8AE/nq8XrQ0RT4oIHVzOBdEqKfwcYVgbMIu5D7OQ4IWMnqfL7EK6QqtR9s+xU2o1xQ8h7XqKZVbKvzq7kUCT+dRFqL6fT4nbIktppBK8wdbHhk4QHtQmMv4pqbd11tLLAmWyOFA452Ue/8CRbsrAzBSquR7Wowoey2oTjyHQw/cEbjBLQdZc38Fqy4WuKHcck7xJYPZHWxSESruoFZ4gN3E4piNiU=
',
    ),
  ),
);
