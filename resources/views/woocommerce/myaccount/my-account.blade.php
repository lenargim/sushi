<?php
/**
 * My Account page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

defined('ABSPATH') || exit;

/**
 * My Account navigation.
 *
 * @since 2.6.0
 */
?>

<div class="account">
  @php woocommerce_breadcrumb() @endphp
  <div class="container">
    <h1 class="title">Личный кабинет</h1>
    <div class="account__wrap">
      <div class="account__sidebar">
        @php do_action( 'woocommerce_account_navigation' ) @endphp
      </div>
      <div class="account__content woocommerce-MyAccount-content">
        @php do_action( 'woocommerce_account_content' ) @endphp
      </div>
    </div>
  </div>
</div>

