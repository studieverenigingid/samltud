<div class="wrap">

  <h2>SAML Identity Provider Settings</h2>
  <form method="post">
    <?php wp_nonce_field('samltudidp_metadata'); ?>
    <h3>Autofill using Metadata</h3>
    <label for="metadata_url">URL to IdP Metadata </label>
    <input type="text" name="metadata_url" size="40">
    <input type="submit" name="fetch_metadata" class="button" value="Fetch metadata">
  </form>

  <div class="option-separator"><span class="caption">OR</span></div>

  <form method="post" action="<?php echo $_SERVER['PHP_SELF'] . '?page=' . basename(__FILE__); ?>&updated=true">
    <?php wp_nonce_field('samltudidp_manual'); ?>
    <h3>Enter IdP Info Manually</h3>
    <fieldset class="options">
      <table class="form-table">
        <?php foreach($metadata as $key => $idp) { ?>
        <tr valign="top">
          <th scope="row">
            <label for="idp_name">IdP name</label>
          </th>
          <td>
            <input type="text" name="idp_name" id="sp_auth_inp"
              value="<?php echo $idp['name']['en']; ?>" size="40">
          </td>
        </tr>
        <tr valign="top">
          <th scope="row">
            <label for="idp_identifier">URL Identifier</label>
          </th>
          <td>
            <input type="text" name="idp_identifier" id="idp_identifier"
              value="<?php echo $key; ?>" size="40">
          </td>
        </tr>
        <tr valign="top">
          <th scope="row">
            <label for="idp_signon">Single Sign-On URL</label>
          </th>
          <td>
            <input type="text" name="idp_signon" id="idp_signon"
              value="<?php echo $idp['SingleSignOnService']; ?>" size="40">
          </td>
        </tr>
        <tr valign="top">
          <th scope="row">
            <label for="idp_logout">Single Logout URL</label>
          </th>
          <td>
            <input type="text" name="idp_logout" id="idp_logout"
              value="<?php echo $idp['SingleLogoutService']; ?>" size="40">
          </td>
        </tr>
        <tr valign="top">
          <th scope="row">
            <label for="idp_fingerprint">Certificate Fingerprint</label>
          </th>
          <td>
            <input type="text" name="idp_fingerprint" id="idp_fingerprint"
              value="<?php echo implode(":",str_split($idp['certFingerprint'],2)); ?>"
              size="40" style="font-family: monospace;">
          </td>
        </tr>
        <?php } ?>
      </table>
    </fieldset>
    <div class="submit">
      <input type="submit" name="submit" class="button button-primary" value="Save">
    </div>
  </form>

</div>
