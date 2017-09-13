<div class="wrap">

	<?php if ($status->html !== '<table class="saml_status">'."\n".'</table>'."\n"): ?>
		<h3>Status</h3>
		<?php echo $status->html; ?>
		<div class="option-separator"></div>
	<?php else: ?>
		<h3>Status: <span class="green">ok</span></h3>
	<?php endif; ?>


	<h3>Your SAML Info</h3>
	<p>
		Your metadata: <br>
		<a href="<?php echo constant('SAMLTUD_AUTH_MD_URL'); ?>">
			<?php echo constant('SAMLTUD_AUTH_MD_URL'); ?>
		</a>
	</p>
  <p>
    <strong>Your Entity ID:</strong>
    <pre class="metadata-box">
    	<?php echo $metadata['entityID'];?>
    </pre>
  </p>
  <p>
    <strong>Your Single Logout URL:</strong>
    <pre class="metadata-box">
    	<?php echo $metadata['Logout'];?>
    </pre>
  </p>
  <p>
    <strong>Your SAML Assertion Consumer URL:</strong>
    <pre class="metadata-box">
    	<?php echo $metadata['Consumer'];?>
    </pre>
  </p>


  <div class="option-separator"></div>


	<form method="post">
		<?php wp_nonce_field('samltud_general'); ?>
		<table class="form-table">
			<tr valign="top">
		    <th scope="row">
					<label for="enabled">
						<strong>Enable SAML authentication</strong>
					</label>
				</th>

				<?php $checked = ($saml_opts['enabled']) ? ' checked="checked"' : ''; ?>
				<td>
					<input type="checkbox" name="enabled" id="enabled" value="enabled"
						<?php echo $checked; ?>>
		    </td>
	    </tr>
		  <tr>
		    <td>
					<input type="submit" name="submit" class="button button-primary" value="Save">
				</td>
		  </tr>
		</table>
	</form>
</div>
