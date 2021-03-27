<?php
/**
 * Checkout Payment Section
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/payment.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.3
 */

defined('ABSPATH') || exit;

if (!is_ajax()) {
  do_action('woocommerce_review_order_before_payment');
}
?>
<div id="payment" class="woocommerce-checkout-payment">
  <?php if ( WC()->cart->needs_payment() ) : ?>
  <ul class="wc_payment_methods payment_methods methods">
    <?php
    if (!empty($available_gateways)) {
      foreach ($available_gateways as $gateway) {
        wc_get_template('checkout/payment-method.php', array('gateway' => $gateway));
      }
    } else {
      echo '<li class="woocommerce-notice woocommerce-notice--info woocommerce-info">Укажите адрес в пределах зон доставки</li>'; // @codingStandardsIgnoreLine
    }
    ?>
  </ul>
  <?php endif; ?>
  <div class="order__free-shipping">
    @php
      $shipping_packages =  WC()->cart->get_shipping_packages();
      $shipping_zone = wc_get_shipping_zone( reset( $shipping_packages ) );
      $zone_name = $shipping_zone->get_zone_name();
      $free_shipping_zone = get_free_shipping_minimum( $zone_name );
    @endphp
    @if( $free_shipping_zone )
      @php
        $free_shipping_min = $free_shipping_zone;
        $total =  WC()->cart->get_subtotal();
      @endphp
      @if ($total < $free_shipping_min)
        @php $remain = $free_shipping_min - $total @endphp
        <div class="remaining">Закажите еще на @php echo $remain  @endphp руб и доставка БЕСПЛАТНО</div>
      @endif
    @endif
  </div>
  <div class="order__totals">
    <div class="order__total">
      Итого: <span class="order__total-span">@php wc_cart_totals_order_total_html() @endphp</span>
    </div>
    <div class="order__total-details">
      @php $coupon = WC()->cart->get_cart_discount_total() @endphp
      @php $sales = getDiscount() @endphp
      @php $totalDiscount = $coupon +  $sales @endphp
      @if( $totalDiscount > 0 )
        <div class="order__discount">
          Скидка: <span>@php echo $totalDiscount . ' ₽' @endphp</span>
        </div>
      @endif
      @php $order_shipping_total = WC()->cart->get_cart_shipping_total() @endphp
      @if( $free_shipping_zone )
        <div class="order__deliver">
          Доставка: <span>
          @php echo $order_shipping_total @endphp
        </span>
        </div>
      @endif
    </div>
  </div>
  <div class="place-order order__pay">
    <noscript>
      <?php
      /* translators: $1 and $2 opening and closing emphasis tags respectively */
      printf(esc_html__('Since your browser does not support JavaScript, or it is disabled, please ensure you click the %1$sUpdate Totals%2$s button before placing your order. You may be charged more than the amount stated above if you fail to do so.', 'woocommerce'), '<em>', '</em>');
      ?>
      <br/>
      <button type="submit" class="button alt" name="woocommerce_checkout_update_totals"
              value="<?php esc_attr_e('Update totals', 'woocommerce'); ?>"><?php esc_html_e('Update totals', 'woocommerce'); ?></button>
    </noscript>

    <?php wc_get_template('checkout/terms.php'); ?>

    <?php do_action('woocommerce_review_order_before_submit'); ?>

    <button type="submit" class="button order__pay-button alt" name="woocommerce_checkout_place_order" id="place_order"
            value="Оплатить">Оплатить
    </button>
    <div class="order__terms">
      <span class="woocommerce-terms-and-conditions-checkbox-text">
            Нажимая кнопку "Оплатить" вы даете согласие на обработку своих <a
          href="@php echo get_privacy_policy_url() @endphp">персональных данных</a>.
          </span>
    </div>

    <?php do_action('woocommerce_review_order_after_submit'); ?>

    <?php wp_nonce_field('woocommerce-process_checkout', 'woocommerce-process-checkout-nonce'); ?>
  </div>
</div>
<?php
if (!is_ajax()) {
  do_action('woocommerce_review_order_after_payment');
}
