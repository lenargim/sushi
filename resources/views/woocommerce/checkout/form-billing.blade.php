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
    {{--    <p class="form-row form-row-first" id="billing_first_name_field">--}}
    {{--    <span class="woocommerce-input-wrapper">--}}
    {{--      <input type="text"--}}
    {{--             class="input-text"--}}
    {{--             name="billing_first_name"--}}
    {{--             id="billing_first_name"--}}
    {{--             placeholder="ФИО"--}}
    {{--             autocomplete="off">--}}
    {{--    </span>--}}
    {{--    </p>--}}
    {{--    <p class="form-row form-row-wide" id="billing_phone_field">--}}
    {{--    <span class="woocommerce-input-wrapper">--}}
    {{--      <input type="tel"--}}
    {{--             class="input-text"--}}
    {{--             name="billing_phone"--}}
    {{--             id="billing_phone"--}}
    {{--             placeholder="Телефон"--}}
    {{--             autocomplete="off">--}}
    {{--    </span>--}}
    {{--    </p>--}}
    {{--    <p class="form-row form-row-wide address-field" id="billing_address_1_field">--}}
    {{--    <span class="woocommerce-input-wrapper">--}}
    {{--      <input type="text"--}}
    {{--             class="input-text"--}}
    {{--             name="billing_address_1"--}}
    {{--             id="billing_address_1"--}}
    {{--             placeholder="Адрес доставки"--}}
    {{--             autocomplete="off"></span>--}}
    {{--    </p>--}}
    {{--    <p class="form-row form-row-wide address-field update_totals_on_change" id="billing_country_field">--}}
    {{--      <input type="hidden"--}}
    {{--             name="billing_country"--}}
    {{--             id="billing_country"--}}
    {{--             class="input-text country_to_state">--}}
    {{--    </p>--}}
    @php $fields = $checkout->get_checkout_fields('billing') @endphp
    @foreach ($fields as $key => $field)
      @php woocommerce_form_field($key, $field, $checkout->get_value($key)) @endphp
    @endforeach
    @php  $arr = WC()->cart->get_applied_coupons() @endphp
  </div>
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
