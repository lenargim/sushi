<?php
/**
 * Orders
 *
 * Shows orders on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/orders.php.
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

do_action('woocommerce_before_account_orders', $has_orders); ?>

<h2 class="title">Мои заказы</h2>

<?php if ( $has_orders ) : ?>

@foreach($customer_orders->orders as $customer_order)
  @php $order = wc_get_order($customer_order) @endphp
  <span>@php echo 'Заказ №' . $order->get_order_number() . ' - ' . wc_format_datetime($order->get_date_created(), 'd/m/Y') @endphp</span>
  <table
    class="woocommerce-orders-table woocommerce-MyAccount-orders shop_table shop_table_responsive my_account_orders account-orders-table">
    <thead>
    <tr>
      <th class="account__orders-th">Фото</th>
      <th class="account__orders-th">Наименование</th>
      <th class="account__orders-th">Цена</th>
      <th class="account__orders-th">Количество</th>
      <th class="account__orders-th">Сумма</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($order->get_items() as $item_key => $item)
      @php $product = $item->get_product() @endphp
      <tr>
        <td>
          <div class="account__order-img">@php echo $product->get_image() @endphp</div>
        </td>
        <td>@php echo $product->get_name() @endphp</td>
        <td>@php echo $product->get_price() @endphp</td>
        <td>@php echo $item->get_quantity() @endphp</td>
        <td>@php echo $item->get_subtotal() @endphp</td>
      </tr>
    @endforeach
    </tbody>
  </table>
@endforeach

<?php do_action('woocommerce_before_account_orders_pagination'); ?>

<?php if ( 1 < $customer_orders->max_num_pages ) : ?>
<div class="woocommerce-pagination woocommerce-pagination--without-numbers woocommerce-Pagination">
  <?php if ( 1 !== $current_page ) : ?>
  <a class="woocommerce-button woocommerce-button--previous woocommerce-Button woocommerce-Button--previous button"
     href="<?php echo esc_url(wc_get_endpoint_url('orders', $current_page - 1)); ?>"><?php esc_html_e('&larr;', 'woocommerce'); ?></a>
  <?php endif; ?>

  <?php if ( intval($customer_orders->max_num_pages) !== $current_page ) : ?>
  <a class="woocommerce-button woocommerce-button--next woocommerce-Button woocommerce-Button--next button"
     href="<?php echo esc_url(wc_get_endpoint_url('orders', $current_page + 1)); ?>"><?php esc_html_e('&rarr;', 'woocommerce'); ?></a>
  <?php endif; ?>
</div>
<?php endif; ?>

<?php else : ?>
<div
  class="woocommerce-message woocommerce-message--info woocommerce-Message woocommerce-Message--info woocommerce-info">
  <a class="woocommerce-Button button"
     href="<?php echo esc_url(apply_filters('woocommerce_return_to_shop_redirect', wc_get_page_permalink('shop'))); ?>"><?php esc_html_e('Browse products', 'woocommerce'); ?></a>
  <?php esc_html_e('No order has been made yet.', 'woocommerce'); ?>
</div>
<?php endif; ?>

<?php do_action('woocommerce_after_account_orders', $has_orders); ?>
