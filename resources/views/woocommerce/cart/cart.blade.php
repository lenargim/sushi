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
    <div class="description">
      Обращаем ваше внимание на то, что сумма заказа в корзине рассчитывается без учета доставки,
      когда оператор свяжется с Вами для уточнения заказа, он сообщит цену за доставку.<br>
      Все информацию о стоимости доставки можно узнать в разделе <a class="orange" href="/delivery">"Доставка и
        оплата"</a>, либо по
      телефону
      <a class="orange" href="tel:@php the_field('phone',8) @endphp">@php the_field('phone',8) @endphp</a>.
    </div>
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
        $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
        if ($_product->is_on_sale()) {
          $regular_price = $_product->get_regular_price();
          $sale_price = $_product->get_sale_price();
          $discount = ($regular_price - $sale_price) * $cart_item['quantity'];
          $discount_total += $discount;
        }
        ?>

        <div
          class="row woocommerce-cart-form__cart-item <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">
          <div class="product-thumbnail">
            <?php
            $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);
            ?>
            <div class="product-image img">@php echo $thumbnail @endphp</div>
          </div>
          <div class="product-name" data-title="<?php esc_attr_e('Product', 'woocommerce'); ?>">
            <div class="name">@php echo $_product->get_name() @endphp</div>
            <?php
            do_action('woocommerce_after_cart_item_name', $cart_item, $cart_item_key);
            ?>

            @if($_product->get_attribute('weight'))
              <div class="product-attr">
                @php $attr = $_product->get_attribute('weight') .'гр./ ' . $_product->get_attribute( 'calories' ) . ' Ккал' @endphp
                @php echo $attr @endphp
              </div>
            @endif
            @if ($_product->get_short_description() )
              <div class="content">
                @php echo wc_short_description($_product,150) @endphp
              </div>
            @endif
            <?php
            // Meta data.
            echo wc_get_formatted_cart_item_data($cart_item); // PHPCS: XSS ok.

            // Backorder notification.
            if ($_product->backorders_require_notification() && $_product->is_on_backorder($cart_item['quantity'])) {
              echo wp_kses_post(apply_filters('woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__('Available on backorder', 'woocommerce') . '</p>', $product_id));
            }
            ?>
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
