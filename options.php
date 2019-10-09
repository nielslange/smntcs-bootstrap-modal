<?php
/**
 * The options page of this plugin.
 *
 * @category   Plugin
 * @package    WordPress
 * @subpackage SMNTCS Bootstrap Modal
 * @author     Niels Lange <info@nielslange.de>
 * @license    GPLv3 http://opensource.org/licenses/gpl-license.php
 */

?>
<div class="wrap">

	<h2>Bootstrap Modal</h2>

	<form method="post" action="options.php">

		<?php wp_nonce_field( 'update-options' ); ?>
		<?php settings_fields( 'smntcs_bootstrap_modal' ); ?>

		<?php if ( get_option( 'smntcs_bootstrap_modal_title' ) && get_option( 'smntcs_bootstrap_modal_shortcode' ) ) : ?>

		<div class="inside">
			<p class="description">
				<label for="smntcsbm-shortcode">Copy this shortcode and paste it into your post, page, or text widget content:</label>
				<span class="shortcode wp-ui-highlight"><input type="text" id="smntcsbm-shortcode" onfocus="this.select();" readonly="readonly" class="large-text code" value="[smntcs-modal]"></span>
			</p>
		</div>

		<?php endif; ?>

		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php esc_attr_e( 'Title:', 'smntcs-bootstrap-modal' ); ?></th>
				<td><input type="text" name="smntcs_bootstrap_modal_title" value="<?php echo esc_attr( get_option( 'smntcs_bootstrap_modal_title' ) ); ?>" size="50" /></td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php esc_attr_e( 'Button:', 'smntcs-bootstrap-modal' ); ?></th>
				<td><input type="text" name="smntcs_bootstrap_modal_button" value="<?php echo esc_attr( get_option( 'smntcs_bootstrap_modal_button' ) ); ?>" size="50" /></td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php esc_attr_e( 'Shortcode:', 'smntcs-bootstrap-modal' ); ?></th>
				<td><input type="text" name="smntcs_bootstrap_modal_shortcode" value="<?php echo esc_textarea( get_option( 'smntcs_bootstrap_modal_shortcode' ) ); ?>" size="50" /></td>
			</tr>
		</table>

		<p class="submit">
			<input type="hidden" name="action" value="update" />
			<input type="submit" class="button-primary" value="<?php esc_attr_e( 'Save Changes', 'smntcs-bootstrap-modal' ); ?>" />
		</p>

	</form>

</div>
