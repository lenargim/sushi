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
      echo '<li class="woocommerce-notice woocommerce-notice--info woocommerce-info">' . apply_filters('woocommerce_no_available_payment_methods_message', WC()->customer->get_billing_country() ? esc_html__('Sorry, it seems that there are no available payment methods for your state. Please contact us if you require assistance or wish to make alternate arrangements.', 'woocommerce') : esc_html__('Please fill in your details above to see available payment methods.', 'woocommerce')) . '</li>'; // @codingStandardsIgnoreLine
    }
    ?>
  </ul>
  <?php endif; ?>
    <div class="order__totals">
      <div class="order__total">
        Итого: <span class="order__total-span">@php wc_cart_totals_order_total_html() @endphp</span>
      </div>
      @php $coupon = WC()->cart->get_cart_discount_total() @endphp
      @php $sales = getDiscount() @endphp
      @php $totalDiscount = $coupon +  $sales @endphp
      @if( $totalDiscount > 0 )
        <div class="order__discount">
          Скидка: <span>@php echo $totalDiscount . ' ₽' @endphp</span>
        </div>
      @endif
    </div>
  <div class="form-row place-order order__pay">
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
