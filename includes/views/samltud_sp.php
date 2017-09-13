<div class="wrap">

  <form method="post" enctype="multipart/form-data">

    <?php wp_nonce_field('samltudsp'); ?>
    <input type="hidden" name="MAX_FILE_SIZE" value="4194304">

    <fieldset class="options">

      <h3>Authentication</h3>
      <table class="form-table">
        <input type="hidden" name="idp" id="idp"
          value="<?php echo $this->settings->get_idp(); ?>">

        <tr valign="top">
          <th scope="row">
            <label for="nameidpolicy">NameID Policy:</label>
          </th>
          <td>
            <select name="nameidpolicy">
              <?php
              $policies = array(
                'urn:oasis:names:tc:SAML:1.1:nameid-format:emailAddress',
                'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',
                'urn:oasis:names:tc:SAML:2.0:nameid-format:persistent'
              );
              foreach($policies as $policy) {
                $selected = ( $this->settings->get_nameidpolicy() == $policy ) ? ' selected="selected"' : '';
                echo '<option value="' . $policy . '"' . $selected . '>' . $policy . '</option>'."\n";
              }
              ?>
            </select>
          </td>
        </tr>
        <tr>
          <th scope="row">&nbsp;</th>
          <td>
            <input type="checkbox" name="auto_cert" value="auto_cert" onclick="jQuery('.manual_cert').toggle('300');">
            &nbsp;&nbsp;Generate a new certificate and private key for me
          </td>
        </tr>
      </table>


      <h3>Attributes</h3>
      <table class="form-table">
        <tr valign="top">
          <th scope="row">
            <label for="username_attribute">Attribute to be used as username</label>
          </th>
          <td>
            <input type="text" name="username_attribute" id="username_attribute_inp"
              value="<?php echo $this->settings->get_attribute('username'); ?>"
              size="40" data-if-empty="error">
          </td>
        </tr>

        <tr valign="top">
          <th scope="row">
            <label for="firstname_attribute">Attribute to be used as First Name</label>
          </th>
          <td>
            <input type="text" name="firstname_attribute" id="firstname_attribute_inp"
              value="<?php echo $this->settings->get_attribute('firstname'); ?>"
              size="40" data-if-empty="warning">
          </td>
        </tr>

        <tr valign="top">
          <th scope="row">
            <label for="lastname_attribute">Attribute to be used as Last Name</label>
          </th>
          <td>
            <input type="text" name="lastname_attribute" id="lastname_attribute_inp"
              value="<?php echo $this->settings->get_attribute('lastname'); ?>"
              size="40" data-if-empty="warning">
          </td>
        </tr>

        <tr valign="top">
          <th scope="row">
            <label for="email_attribute">Attribute to be used as E-mail</label>
          </th>
          <td>
            <input type="text" name="email_attribute" id="email_attribute_inp"
              value="<?php echo $this->settings->get_attribute('email'); ?>"
              size="40" data-if-empty="warning">
          </td>
        </tr>
      </table>
    </fieldset>

    <div class="submit">
      <input type="submit" name="submit" class="button button-primary" value="Save">
    </div>

  </form>

</div>
