<?php
/**
 * Edit account form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_edit_account_form' ); ?>

<form class="account__dashboard-edit woocommerce-EditAccountForm edit-account" action="" method="post" <?php do_action( 'woocommerce_edit_account_form_tag' ); ?> >

	<?php do_action( 'woocommerce_edit_account_form_start' ); ?>

	<p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
		<input placeholder="Имя" type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_first_name" id="account_first_name" autocomplete="given-name" value="<?php echo esc_attr( $user->first_name ); ?>" />
	</p>
  <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
    <input placeholder="Телефон" type="tel" class="woocommerce-Input woocommerce-Input--phone input-text" name="billing_phone" id="billing_phone" value="<?php echo esc_attr( $user->billing_phone ); ?>" />
  </p>

  <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
    <input placeholder="Адрес" type="text" class="woocommerce-Input woocommerce-Input--phone input-text" name="billing_address_1" id="billing_address_1" value="<?php echo esc_attr( $user->billing_address_1 ); ?>" />
  </p>

  <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
    <input placeholder="Квартира" type="text" class="woocommerce-Input woocommerce-Input--phone input-text" name="billing_address_2" id="billing_address_2" value="<?php echo esc_attr( $user->billing_address_2 ); ?>" />
  </p>

	<?php do_action( 'woocommerce_edit_account_form' ); ?>

	<p class="submit-box">
		<?php wp_nonce_field( 'save_account_details', 'save-account-details-nonce' ); ?>
		<button type="submit" class="woocommerce-Button button" name="save_account_details" value="<?php esc_attr_e( 'Save changes', 'woocommerce' ); ?>">Сохранить</button>
		<input type="hidden" name="action" value="save_account_details" />
	</p>

	<?php do_action( 'woocommerce_edit_account_form_end' ); ?>
</form>

<?php do_action( 'woocommerce_after_edit_account_form' ); ?>
