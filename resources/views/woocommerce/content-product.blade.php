<?php

defined('ABSPATH') || exit;

global $product;

// Ensure visibility.
if (empty($product) || !$product->is_visible()) {
  return;
}
?>

@php
  $id = $product->get_id();
  $attachment_ids = $product->get_gallery_image_ids();
  $quantitiesArray = WC()->cart->get_cart_item_quantities();
  if ( isset($quantitiesArray[$id]) ) {
    $productQuantity = $quantitiesArray[$id];
  } else {
    $productQuantity = 0;
  }
@endphp
<li <?php wc_product_class('', $product); ?>
    data-id="@php echo $id @endphp"
    data-quantity="@php echo $productQuantity @endphp">

  <div class="gallery modal" data-id="@php echo $id @endphp" data-quantity="@php echo $productQuantity @endphp">
    @include('icon::search-close', ['class' => 'close gallery__close'])
    <div class="gallery__images">
      <div class="gallery__image">
        @php echo get_the_post_thumbnail( $id, 'shop_single' ); @endphp
      </div>
      @if($attachment_ids)
        @foreach(  $attachment_ids as $attachment_id )
          <div class="gallery__image">
            @php echo wp_get_attachment_image( $attachment_id, 'shop_catalog' ); @endphp
          </div>
        @endforeach
      @endif
    </div>
    <div class="gallery__info">
      <div class="gallery__name">@php echo $product->get_name() @endphp</div>
      @if( $product->get_attribute('weight') !== '' )
        @php $attr = $product->get_attribute('weight') .'гр./ ' . $product->get_attribute( 'calories' ) . ' Ккал' @endphp
        <div class="gallery__attr">@php echo $attr @endphp</div>
      @endif
      <span class="gallery__short-desc">@php echo $product->get_short_description() @endphp</span>
      <div class="gallery__short-desc">@php the_content() @endphp</div>
      <div class="gallery__price">
        @if( $product->get_price() == $product->get_regular_price() )
          @if($product->get_price())
            <span class="gallery__main-price">@php echo $product->get_price() . ' ₽' @endphp</span>
          @endif
        @else
          <span class="gallery__main-price">@php echo $product->get_price() . ' ₽' @endphp</span>
          <span class="gallery__old-price">@php echo $product->get_regular_price() . ' ₽' @endphp</span>
        @endif
      </div>
      @if($product->get_price())
        @php do_action( 'woocommerce_after_shop_loop_item' ); @endphp
      @endif
    </div>
  </div>

  @php $tagList = wc_get_product_tag_list( $product->get_id(), "", "", "" ) @endphp
  <div class="product__tags">
    @php echo $tagList @endphp
  </div>
  <div class="product__img" data-id="@php echo $product->get_id() @endphp">
    @php echo $product->get_image('', ['style="aspect-ratio: 938 / 623;"']) @endphp
  </div>
  <div class="product__info">
    <div class="product__title">@php echo $product->get_name() @endphp</div>
    <span class="product__short-desc">@php echo wc_short_description($product, 120) @endphp</span>
    @if ( $product->has_weight() )
      @php $weight = $product->get_weight() @endphp
      <div class="product__attributes">@php echo $weight @endphp гр.</div>
    @endif
    <div class="product__price">
      @if( $product->get_price() == $product->get_regular_price() )
        @if($product->get_price())
          <span class="product__main-price">@php echo $product->get_price() . ' ₽' @endphp</span>
        @else
          <div class="product__main-price">Цена не указана</div>
        @endif
      @else
        <span class="product__main-price">@php echo $product->get_price() . ' ₽' @endphp</span>
        <span class="product__old-price">@php echo $product->get_regular_price() . ' ₽' @endphp</span>
      @endif
    </div>
    @if($product->get_price())
      @php do_action( 'woocommerce_after_shop_loop_item' ); @endphp
    @endif
  </div>
</li>
