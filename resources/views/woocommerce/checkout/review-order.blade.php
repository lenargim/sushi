<?php
/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.8.0
 */

defined('ABSPATH') || exit;
?>
<div class="shop_table woocommerce-checkout-review-order-table order__table">
  <?php
  do_action('woocommerce_review_order_before_cart_contents');
  ?>

  @php
    $quantitiesArray = WC()->cart->get_cart_item_quantities();
  @endphp
  <?php
  global $discount_total;
  $discount_total = 0;
  function getDiscount(){
    global $discount_total;
    return $discount_total;
  }
  ?>
  <div class="tr">
    <div class="th">Фото</div>
    <div class="th">Наименование</div>
    <div class="th" style="width: 132px;">Цена</div>
    <div class="th">Количество</div>
    <div class="th">Сумма</div>
  </div>
  <?php
  foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
  $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
  if ($_product->is_on_sale()) {
    $regular_price = $_product->get_regular_price();
    $sale_price = $_product->get_sale_price();
    $discount = ($regular_price - $sale_price) * $cart_item['quantity'];
    $discount_total += $discount;
  }
  if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key) ) {
  ?>

  <div class="tr"
    class="<?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">
    <div class="td" class="product-photo">
      <div class="product-photo__img img">
        @php echo $_product->get_image() @endphp
      </div>
    </div>
    <div class="td" class="product-name">
      <span class="hidden">Наименование</span>
      @php echo $_product->get_name(); @endphp
    </div>
    <div class="td" class="product-price">
      <span class="hidden">Цена</span>
      @php $price = $_product->get_price() @endphp
      @php echo $price . ' ₽' @endphp
    </div>
    <div class="td" class="product-quantity">
      <span class="hidden">Количество</span>
      @php $quantity = $quantitiesArray[$_product->get_id()] @endphp
      @php echo $quantity @endphp
    </div>
    <div class="td" class="product-total">
      <span class="hidden">Сумма</span>
      @php $total = $quantity * $price @endphp
      @php echo $total . ' ₽' @endphp
    </div>
  </div>
  <?php
  }
  }

  do_action('woocommerce_review_order_after_cart_contents');
  ?>
  <?php do_action('woocommerce_review_order_before_order_total'); ?>
  <div class="order-total">
    <p>Итого:</p>@php wc_cart_totals_order_total_html() @endphp
  </div>
  <?php do_action('woocommerce_review_order_after_order_total'); ?>
</div>
