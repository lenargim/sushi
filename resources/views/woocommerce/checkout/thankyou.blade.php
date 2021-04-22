<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.7.0
 */

defined('ABSPATH') || exit;
?>

<div class="woocommerce-order">


  <?php
  if ( $order ) :
  do_action('woocommerce_before_thankyou', $order->get_id());
  ?>

  <?php if ( $order->has_status('failed') ) : ?>

  <p
    class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"><?php esc_html_e('Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce'); ?></p>

  <p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
    <a href="<?php echo esc_url($order->get_checkout_payment_url()); ?>"
       class="button pay"><?php esc_html_e('Pay', 'woocommerce'); ?></a>
    <?php if ( is_user_logged_in() ) : ?>
    <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>"
       class="button pay"><?php esc_html_e('My account', 'woocommerce'); ?></a>
    <?php endif; ?>
  </p>

  <?php else : ?>
  <div class="overlay active">
    <div class="thankyou modal active">
      @include('icon::search-close', ['class' => 'thankyou__close close'])
      @include('icon::thankyou')
      <div class="thankyou__title">@php echo $order->get_billing_first_name() . ', спасибо за Ваш заказ!' @endphp</div>
      <div class="thankyou__number">
        <span>Номер вашего заказа:</span> <span class="orange">@php echo $order->get_order_number() @endphp
      </div>
      <div class="thankyou__phone">
        <span>Телефон:</span>
        <span>@php echo $order->get_billing_phone() @endphp</span>
      </div>
      <div class="thankyou__notice">В ближайшее время с вами свяжется оператор<br> для подвтерждения заказа.</div>
    </div>
  </div>
  <?php endif; ?>
  <?php do_action('woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id()); ?>
  <?php endif; ?>
</div>
