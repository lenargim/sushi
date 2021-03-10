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
<table class="shop_table woocommerce-checkout-review-order-table order__table">
  <thead>
  <tr>
    <th>Фото</th>
    <th>Наименование</th>
    <th style="width: 132px;">Цена</th>
    <th>Количество</th>
    <th>Сумма</th>
  </tr>
  </thead>
  <tbody>
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
  <tr
    class="<?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">
    <td class="product-photo">
      <div class="product-photo__img">
        @php echo $_product->get_image() @endphp
      </div>
    </td>
    <td class="product-name">
      @php echo $_product->get_name(); @endphp
    </td>
    <td class="product-price">
      @php $price = $_product->get_price() @endphp
      @php echo $price . ' ₽' @endphp
    </td>
    <td class="product-quantity">
      @php $quantity = $quantitiesArray[$_product->get_id()] @endphp
      @php echo $quantity @endphp
    </td>
    <td class="product-total">
      @php $total = $quantity * $price @endphp
      @php echo $total . ' ₽' @endphp
    </td>
  </tr>
  <?php
  }
  }

  do_action('woocommerce_review_order_after_cart_contents');
  ?>
  </tbody>
  <tfoot>
  <?php do_action('woocommerce_review_order_before_order_total'); ?>
  <tr class="order-total">
    <td colspan="4"></td>
    <td>Итого:<br>@php wc_cart_totals_order_total_html() @endphp</td>
  </tr>
  <?php do_action('woocommerce_review_order_after_order_total'); ?>
  </tfoot>
</table>
