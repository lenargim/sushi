<?php
/**
 * Empty cart page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-empty.php.
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

defined( 'ABSPATH' ) || exit;

/*
 * @hooked wc_empty_cart_message - 10
 */

?>

@php do_action( 'woocommerce_cart_is_empty' ) @endphp

<div class="cart">
  @php woocommerce_breadcrumb() @endphp
  <div class="container">
    <div class="cart__empty">
      <h1 class="title">Корзина пуста</h1>
      <p class="description">Вернуться в <a href="/shop">Магазин</a></p>
    </div>
  </div>
</div>


@include('partials.map')