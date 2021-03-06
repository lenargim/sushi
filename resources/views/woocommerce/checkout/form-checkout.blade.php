<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
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

if (!defined('ABSPATH')) {
  exit;
}

do_action('woocommerce_before_checkout_form', $checkout);
?>
<?php
// If checkout registration is disabled and not logged in, the user cannot checkout.
if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) {
echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'woocommerce')));
return;
}

?>

<div class="order">
  @php woocommerce_breadcrumb() @endphp
  <div class="container">
    <h1 class="title">{{ the_title() }}</h1>
    <div class="label-back">
      Оплата<br>
      Оплата<br>
      Оплата<br>
      Оплата<br>
    </div>
    <form name="checkout" method="post" class="checkout woocommerce-checkout order__form"
          action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">
      <?php do_action('woocommerce_checkout_before_order_review'); ?>
      <?php do_action('woocommerce_checkout_order_review'); ?>
      <?php do_action('woocommerce_checkout_after_order_review'); ?>
      <?php if ( $checkout->get_checkout_fields() ) : ?>
      <?php do_action('woocommerce_checkout_before_customer_details'); ?>
      <div class="order__details" id="customer_details">
        <?php do_action('woocommerce_checkout_billing'); ?>
        <?php do_action( 'woocommerce_checkout_shipping' ); ?>
        <?php do_action('woocommerce_checkout_after_customer_details'); ?>
          @php  $arr = WC()->cart->get_applied_coupons() @endphp
          <div class="order__coupon">
            @if(!$arr)
              <input form="form-coupon" type="text" name="coupon_code" autocomplete="off"
                     class="input-text order__coupon-input" placeholder="Промокод"
                     id="coupon_code" value=""/>
              <button form="form-coupon" type="submit" class="button order__coupon-button" name="apply_coupon"
                      value="Применить">Применить
              </button>
            @else
              <p class="order__coupon-added">Купон @php echo $arr[0] @endphp применен</p>
            @endif
          </div>
      </div>
      <?php endif; ?>
      <?php do_action('woocommerce_checkout_before_order_review_heading'); ?>
    </form>
    <?php do_action('woocommerce_after_checkout_form', $checkout); ?>
  </div>
@include('partials.map')
