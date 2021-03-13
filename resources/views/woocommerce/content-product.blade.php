<?php

defined('ABSPATH') || exit;

global $product;

// Ensure visibility.
if (empty($product) || !$product->is_visible()) {
  return;
}
?>


<li <?php wc_product_class('', $product); ?>>

  @php
    $post_ids = $product->get_id();
    $attachment_ids = $product->get_gallery_image_ids();
  @endphp
  <div class="gallery modal" data-id="@php echo $post_ids @endphp">
    @include('icon::search-close', ['class' => 'close gallery__close'])
    <div class="gallery__images">
      <div class="gallery__image">
        @php echo get_the_post_thumbnail( $post_ids, 'shop_single' ); @endphp
      </div>
      @foreach(  $attachment_ids as $attachment_id )
        <div class="gallery__image">
          @php echo wp_get_attachment_image( $attachment_id, 'shop_catalog' ); @endphp
        </div>
      @endforeach
    </div>
    <div class="gallery__info">
      <div class="gallery__name">@php echo $product->get_name() @endphp</div>
      @php $attr = $product->get_attribute('weight') .'гр./ ' . $product->get_attribute( 'calories' ) . ' Ккал' @endphp
      <div class="gallery__attr">@php echo $attr @endphp</div>
      <span class="gallery__short-desc">@php echo $product->get_short_description() @endphp</span>
      <div class="gallery__price">
        @if( $product->get_price() == $product->get_regular_price() )
          <span class="gallery__main-price">@php echo $product->get_price() . ' ₽' @endphp</span>
        @else
          <span class="gallery__main-price">@php echo $product->get_price() . ' ₽' @endphp</span>
          <span class="gallery__old-price">@php echo $product->get_regular_price() . ' ₽' @endphp</span>
        @endif
      </div>
      @php do_action( 'woocommerce_after_shop_loop_item' ); @endphp
    </div>
  </div>


  @php $tagList = wc_get_product_tag_list( $product->get_id(), "", "", "" ) @endphp
  <div class="product__tags">
    @php echo $tagList @endphp
  </div>
  <div class="product__img" data-id="@php echo $product->get_id() @endphp">
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
