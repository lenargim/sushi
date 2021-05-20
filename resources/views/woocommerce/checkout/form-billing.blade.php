<?php
/**
 * Checkout billing information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-billing.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 * @global WC_Checkout $checkout
 */

defined('ABSPATH') || exit;
?>
<div class="woocommerce-billing-fields">
  <h3>Данные для доставки</h3>

  <?php do_action('woocommerce_before_checkout_billing_form', $checkout); ?>

  <div class="woocommerce-billing-fields__field-wrapper">
    @php $fields = $checkout->get_checkout_fields('billing') @endphp
    @foreach ($fields as $key => $field)
      @php woocommerce_form_field($key, $field, $checkout->get_value($key)) @endphp
    @endforeach
  </div>
  <?php do_action('woocommerce_after_checkout_billing_form', $checkout); ?>
</div>

<?php if ( !is_user_logged_in() && $checkout->is_registration_enabled() ) : ?>
<div class="woocommerce-account-fields">
  <?php if ( !$checkout->is_registration_required() ) : ?>

  <p class="form-row form-row-wide create-account">
    <label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
      <input class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" id="createaccount"
             <?php checked((true === $checkout->get_value('createaccount') || (true === apply_filters('woocommerce_create_account_default_checked', false))), true); ?> type="checkbox"
             name="createaccount" value="1"/> <span><?php esc_html_e('Create an account?', 'woocommerce'); ?></span>
    </label>
  </p>

  <?php endif; ?>

  <?php do_action('woocommerce_before_checkout_registration_form', $checkout); ?>

  <?php if ( $checkout->get_checkout_fields('account') ) : ?>

  <div class="create-account">
    <?php foreach ($checkout->get_checkout_fields('account') as $key => $field) : ?>
					<?php woocommerce_form_field($key, $field, $checkout->get_value($key)); ?>
				<?php endforeach; ?>
    <div class="clear"></div>
  </div>

  <?php endif; ?>

  <?php do_action('woocommerce_after_checkout_registration_form', $checkout); ?>
</div>
<?php endif; ?>

<div class="overlay active">
  <div class="order__promo modal active">
    @include('icon::search-close', ['class' => 'close gallery__close'])
    @php $total = WC()->cart->cart_contents_total; @endphp
    @if($total >= 1000)
      <div class="order__promo-text">🎉 Забирайте скидку 50% на доставку кальяна на дом 🎉</div>
      <span class="order__promo-more">Подробнее</span>
    <div class="order__promo-addition">
      Нажимая кнопку "Беру", Вы получаете скидку от нашего проекта <a class="orange" href="http://kalian-smr.ru/" target="_blank">VINIпых</a><br>
      Администратор с вами обязательно свяжется согласовать детали.
    </div>
      <div class="order__promo-buttons">
        <div class="order__promo-button button" data-msg="Кальян не нужен">Не беру</div>
        <div class="order__promo-button button" data-msg="Оформи к заказу кальян со скидкой 50%">Беру</div>
      </div>
      @else
      <div class="order__promo-text">
        @php $gap = 1000 - $total @endphp
        Закажи еще на <br>
        <span class="orange">@php echo $gap @endphp рублей </span><br>
        и получи кальян со скидкой 50%
      </div>
    @endif
  </div>
</div>
