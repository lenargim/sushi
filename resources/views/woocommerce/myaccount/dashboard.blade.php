<?php
/**
 * My Account Dashboard
 *
 * Shows the first intro screen on the account dashboard.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/dashboard.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.4.0
 */

?>

<h2>Личные данные</h2>

@php
  $user            = wp_get_current_user();
  $cookies_consent = ( isset( $_POST['wp-comment-cookies-consent'] ) );
@endphp
<div class="account__dashboard">
  <div class="account__dashboard-wrap">
    <div class="account__dashboard-item">
      <label>Имя</label>
      <span>@php echo esc_attr( $user->first_name ) @endphp</span>
    </div>
    <div class="account__dashboard-item">
      <label>Номер телефона</label>
      <span>@php echo esc_attr( $user->billing_phone ) @endphp</span>
    </div>
    <div class="account__dashboard-item">
      <label>Адрес доставки</label>
      <span>@php echo esc_attr( $user->billing_address_1 ) . ', кв.' . esc_attr( $user->billing_address_2 ); @endphp</span>
    </div>
  </div>
  <div class="button account__dashboard-button">Редактировать</div>
</div>

@php require_once get_template_directory() . '/views/woocommerce/myaccount/form-edit-account.php' @endphp
