<?php

defined('ABSPATH') || exit;

global $product;

// Ensure visibility.
if (empty($product) || !$product->is_visible()) {
  return;
}
?>


<li <?php wc_product_class('', $product); ?>>
  @php $tagList = wc_get_product_tag_list( $product->get_id(), "", "", "" ) @endphp
      <div class="product__tags">
        @php echo $tagList @endphp
    </div>
  <div class="product__img">
    @php echo $product->get_image() @endphp
  </div>
  <div class="product__info">
    <span class="product__title">@php echo $product->get_name() @endphp</span>
    @php $attr = $product->get_attribute('weight') .'гр./ ' . $product->get_attribute( 'calories' ) . ' Ккал' @endphp
    <div class="product__attributes">@php echo $attr @endphp</div>
    <span class="product__short-desc">@php echo $product->get_short_description() @endphp</span>
    <div class="product__price">
      @if( $product->get_price() == $product->get_regular_price() )
        <span class="product__main-price">@php echo $product->get_price() . ' ₽' @endphp</span>
      @else
        <span class="product__main-price">@php echo $product->get_price() . ' ₽' @endphp</span>
        <span class="product__old-price">@php echo $product->get_regular_price() . ' ₽' @endphp</span>
      @endif
    </div>
    @php do_action( 'woocommerce_after_shop_loop_item' ); @endphp
  </div>
</li>
