<?php
/**
 * Loop Add to Cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/add-to-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.3.0
 */

if (!defined('ABSPATH')) {
  exit;
}

global $product;
?>
@php
  $id = $product->get_id();
  $quantitiesArray = WC()->cart->get_cart_item_quantities();
  if ( isset($quantitiesArray[$id]) ) {
    $productQuantity = $quantitiesArray[$id];
  } else {
    $productQuantity = 0;
  }
@endphp
<div class="product__function">
<div class="product__amount" data-id="@php echo $id @endphp">
  <button class="product__button minus">-</button>
  <input type="number" min="0" max="99" step="1" class="product__quantity" readonly="readonly" value="@php echo $productQuantity @endphp">
  <button class="product__button plus">+</button>
</div>
@php
  echo apply_filters(
  'woocommerce_loop_add_to_cart_link', // WPCS: XSS ok.
  sprintf(
  '<a href="%s" data-quantity="%s" class="%s" %s>
  <svg width="39" height="34" viewBox="0 0 39 34" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M28.1069 5.98659C27.8526 5.5671 27.4883 5.21751 27.0498 4.97194C26.6112 4.72637 26.1132 4.59319 25.6045 4.58539H6.76288L5.90912 1.41869C5.82286 1.113 5.63041 0.844119 5.36312 0.655838C5.09583 0.467556 4.76944 0.370967 4.43712 0.381803H1.49312C1.10272 0.381803 0.728311 0.529429 0.452257 0.792204C0.176203 1.05498 0.0211182 1.41138 0.0211182 1.783C0.0211182 2.15462 0.176203 2.51102 0.452257 2.77379C0.728311 3.03657 1.10272 3.1842 1.49312 3.1842H3.3184L7.38112 17.5605C7.46738 17.8662 7.65983 18.135 7.92712 18.3233C8.19441 18.5116 8.5208 18.6082 8.85312 18.5973H22.1011C22.373 18.5966 22.6393 18.5241 22.8705 18.3881C23.1017 18.2521 23.2889 18.0578 23.4112 17.8267L28.2394 8.63485C28.4486 8.21731 28.5461 7.75696 28.5229 7.29486C28.4998 6.83276 28.3569 6.3833 28.1069 5.98659ZM21.1885 15.795H9.97184L7.57248 7.38778H25.6045L21.1885 15.795Z" fill="white"/>
<path d="M8.1172 25.6032C9.33664 25.6032 10.3252 24.6622 10.3252 23.5015C10.3252 22.3407 9.33664 21.3997 8.1172 21.3997C6.89775 21.3997 5.90919 22.3407 5.90919 23.5015C5.90919 24.6622 6.89775 25.6032 8.1172 25.6032Z" fill="white"/>
<path d="M22.8372 25.6032C24.0567 25.6032 25.0452 24.6622 25.0452 23.5015C25.0452 22.3407 24.0567 21.3997 22.8372 21.3997C21.6178 21.3997 20.6292 22.3407 20.6292 23.5015C20.6292 24.6622 21.6178 25.6032 22.8372 25.6032Z" fill="white"/>
<path d="M37.5716 23.7988C37.5716 22.2968 36.354 21.0792 34.852 21.0792H31.5852V18.1873C31.5852 16.6373 30.3287 15.3807 28.7787 15.3807C27.2287 15.3807 25.9721 16.6373 25.9721 18.1873V21.0792H22.7054C21.2034 21.0792 19.9857 22.2968 19.9857 23.7988C19.9857 25.3009 21.2034 26.5185 22.7054 26.5185H25.9721V29.4104C25.9721 30.9604 27.2287 32.2169 28.7787 32.2169C30.3287 32.2169 31.5852 30.9604 31.5852 29.4104V26.5185H34.852C36.354 26.5185 37.5716 25.3009 37.5716 23.7988Z" fill="white" stroke="#FF651D" stroke-width="2"/>
</svg>
  </a>',
  esc_url( $product->add_to_cart_url() ),
  esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
  esc_attr( isset( $args['class'] ) ? $args['class'] : 'button' ),
  isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
  ),
  $product,
  $args
  )
@endphp
</div>
