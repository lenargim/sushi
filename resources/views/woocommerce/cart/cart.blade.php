<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.8.0
 */

defined('ABSPATH') || exit;
?>

<div class="cart">
  @php woocommerce_breadcrumb() @endphp
  <div class="container">
    <h1 class="title">{{the_title()}}</h1>
    <div class="label-back">
      Корзина<br>
      Корзина<br>
      Корзина<br>
      Корзина<br>
    </div>
    @php do_action( 'woocommerce_before_cart' ) @endphp
    <form class="woocommerce-cart-form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
      <?php do_action('woocommerce_before_cart_table'); ?>

      <div class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
        <?php do_action('woocommerce_before_cart_contents'); ?>
        <?php
        $discount_total = 0;
        foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
        $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
        $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

        if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key) ) {
        if ($_product->is_on_sale()) {
          $regular_price = $_product->get_regular_price();
          $sale_price = $_product->get_sale_price();
          $discount = ($regular_price - $sale_price) * $cart_item['quantity'];
          $discount_total += $discount;
        }
        ?>
        @php
          $attachment_ids = $_product->get_gallery_image_ids();
          $quantitiesArray = WC()->cart->get_cart_item_quantities();
        @endphp
        <div
          class="row woocommerce-cart-form__cart-item <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>" data-id="@php echo $product_id @endphp">
          <div class="gallery modal" data-id="@php echo $product_id @endphp">
            @include('icon::search-close', ['class' => 'close gallery__close'])
            <div class="gallery__images">
              <div class="gallery__image">
                @php echo get_the_post_thumbnail( $product_id, 'shop_single' ); @endphp
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
              <div class="gallery__name">@php echo $_product->get_name() @endphp</div>
              <span class="gallery__short-desc">@php echo $_product->get_short_description() @endphp</span>
              <div class="gallery__short-desc">@php  $_product->get_description() @endphp</div>
              <div class="gallery__short-desc">Вес: @php echo $_product->get_weight() @endphp гр.</div>
              <div class="gallery__price">
                @if( $_product->get_price() == $_product->get_regular_price() )
                  @if($_product->get_price())
                    <span class="gallery__main-price">@php echo $_product->get_price() . ' ₽' @endphp</span>
                  @endif
                @else
                  <span class="gallery__main-price">@php echo $_product->get_price() . ' ₽' @endphp</span>
                  <span class="gallery__old-price">@php echo $_product->get_regular_price() . ' ₽' @endphp</span>
                @endif
              </div>
            </div>
          </div>
          <div class="product-thumbnail">
            <?php
            $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);
            ?>
            <div class="product-image img">@php echo $thumbnail @endphp</div>
          </div>
          <div class="product-name" data-title="<?php esc_attr_e('Product', 'woocommerce'); ?>">
            <div class="name">@php echo $_product->get_name() @endphp</div>
            @if ($_product->get_short_description() )
              <div class="content">
                @php echo wc_short_description($_product,120); @endphp
              </div>
            @endif
            @if ( $_product->has_weight() )
              @php $weight = $_product->get_weight() @endphp
              <div class="weight">@php echo $weight @endphp гр.</div>
            @endif
          </div>
          <div class="product-price" data-title="<?php esc_attr_e('Price', 'woocommerce'); ?>">
            <div class="product-price__wrap">
              <?php
              echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key); // PHPCS: XSS ok.
              ?>
            </div>
          </div>
          <div class="product-quantity" data-title="<?php esc_attr_e('Quantity', 'woocommerce'); ?>">
            <?php
            if ($_product->is_sold_individually()) {
              $product_quantity = sprintf('1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key);
            } else {
              ?>
              <?php
              $product_quantity = woocommerce_quantity_input(
                array(
                  'input_name' => "cart[{$cart_item_key}][qty]",
                  'input_value' => $cart_item['quantity'],
                  'max_value' => $_product->get_max_purchase_quantity(),
                  'min_value' => '0',
                  'product_name' => $_product->get_name(),
                ),
                $_product,
                false
              );
            }
            ?>
            <?php
            echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item); // PHPCS: XSS ok.
            ?>
          </div>
          <div class="product-remove">
            <a href="@php echo wc_get_cart_remove_url($cart_item_key) @endphp" class="remove"
               aria-label="Удалить товар"
               data-product_id="@php echo $product_id @endphp"
               data-product_sku="@php echo $_product->get_sku() @endphp">
              @include('icon::trash', ['class' =>'trash'])
            </a>
          </div>
        </div>
        <?php
        }
        }
        ?>
        <?php do_action('woocommerce_cart_contents'); ?>
          <tr>
            <td colspan="6" class="actions">

              <button type="submit" class="button reload-button" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>"><?php esc_html_e( 'Update cart', 'woocommerce' ); ?></button>

              <?php do_action( 'woocommerce_cart_actions' ); ?>

              <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
            </td>
          </tr>
        <?php do_action('woocommerce_after_cart_contents'); ?>
        </tbody>
      </div>
      <?php do_action('woocommerce_after_cart_table'); ?>
    </form>
    <div class="cart__extra">
      <h2 class="title">Дополнительно</h2>
      @php woocommerce_product_loop_start() @endphp
      @php
        $args = [
        'post_type'       => 'product',
        'product_cat'     => 'extra',
        'posts_per_page'  => -1,
        'orderby'         => 'date',
        ];
        $extra = new WP_Query($args);
      @endphp
      @if ($extra->have_posts())
        @while($extra->have_posts()) @php $extra->the_post() @endphp
        @php wc_get_template_part( 'content', 'product' ); @endphp
        @endwhile
        @php(wp_reset_postdata()) @endphp
      @endif
      @php woocommerce_product_loop_end() @endphp
    </div>
    <div class="cart__info">
      <div>
        <div class="cart__info-row">
          <span>Скидка:</span>
          <span>@php echo $discount_total . " ₽" @endphp</span>
        </div>
        <div class="cart__info-row">
          <span>Итого:</span>
          <span> @php wc_cart_totals_order_total_html() @endphp</span>
        </div>
      </div>
      <div class="wc-proceed-to-checkout">
      </div>
      <?php do_action('woocommerce_proceed_to_checkout'); ?>
    </div>
    <?php do_action('woocommerce_before_cart_collaterals'); ?>
    <?php do_action('woocommerce_after_cart'); ?>

  </div>
</div>

@include('partials.map')
