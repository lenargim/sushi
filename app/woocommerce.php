<?php

function woocommerce_header_add_to_cart_fragment($fragments)
{
    ob_start();
    ?>
    <a href="/cart" class="menu__cart-wrap">
        <svg class="menu__cart-svg" width="39" height="39" viewBox="0 0 39 39" fill="none"
             xmlns="http://www.w3.org/2000/svg">
            <path
                d="M34.5287 11.2293C34.2429 10.7341 33.8336 10.3214 33.3408 10.0315C32.8479 9.74159 32.2884 9.58437 31.7167 9.57517H10.5439L9.58447 5.83684C9.48753 5.47597 9.27128 5.15856 8.97091 4.93629C8.67055 4.71402 8.30378 4.59999 7.93034 4.61279H4.62208C4.18338 4.61279 3.76265 4.78706 3.45244 5.09727C3.14223 5.40748 2.96796 5.82821 2.96796 6.26691C2.96796 6.70562 3.14223 7.12635 3.45244 7.43656C3.76265 7.74677 4.18338 7.92104 4.62208 7.92104H6.6732L11.2386 24.8924C11.3355 25.2533 11.5518 25.5707 11.8521 25.7929C12.1525 26.0152 12.5193 26.1292 12.8927 26.1164H27.7799C28.0853 26.1155 28.3846 26.03 28.6444 25.8694C28.9043 25.7089 29.1146 25.4795 29.252 25.2067L34.6776 14.3556C34.9127 13.8627 35.0222 13.3192 34.9962 12.7737C34.9703 12.2282 34.8096 11.6976 34.5287 11.2293ZM26.7543 22.8082H14.1499L11.4536 12.8834H31.7167L26.7543 22.8082Z"
                fill="#4B4B4B"/>
            <path
                d="M12.0657 34.3872C13.436 34.3872 14.5469 33.2763 14.5469 31.906C14.5469 30.5357 13.436 29.4248 12.0657 29.4248C10.6953 29.4248 9.58447 30.5357 9.58447 31.906C9.58447 33.2763 10.6953 34.3872 12.0657 34.3872Z"
                fill="#4B4B4B"/>
            <path
                d="M28.6069 34.3872C29.9772 34.3872 31.0881 33.2763 31.0881 31.906C31.0881 30.5357 29.9772 29.4248 28.6069 29.4248C27.2366 29.4248 26.1257 30.5357 26.1257 31.906C26.1257 33.2763 27.2366 34.3872 28.6069 34.3872Z"
                fill="#4B4B4B"/>
        </svg>
        <?php if (WC()->cart->get_cart_contents_count()) { ?>
            <span class="menu__cart-amount"><?php echo WC()->cart->get_cart_contents_count() ?></span>
        <?php } ?>
        <span class="menu__cart-total"><?php echo WC()->cart->cart_contents_total ?> руб</span>
    </a>
    <?php
    $fragments['a.menu__cart-wrap'] = ob_get_clean();
    return $fragments;
}
add_filter('woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment');

// Breadcrumbs


function custom_breadcrumbs()
{
    return array(
        'delimiter' => ' > ',
        'wrap_before' => '<div class="container"><nav class="breadcrumbs">',
        'wrap_after' => '</nav></div>',
        'before' => '',
        'after' => '',
        'home' => _x('Главная', 'breadcrumb', 'woocommerce'),
    );
}
add_filter('woocommerce_breadcrumb_defaults', 'custom_breadcrumbs');


function my_remove_product_result_count() {
    remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
    remove_action('woocommerce_after_shop_loop', 'woocommerce_result_count', 20);
}
add_action('after_setup_theme', 'my_remove_product_result_count', 99);

function dequeue_styles($enqueue_styles)
{
    unset($enqueue_styles['woocommerce-general']);    // Remove the gloss
    unset($enqueue_styles['woocommerce-layout']);        // Remove the layout
    //unset( $enqueue_styles['woocommerce-smallscreen'] );	// Remove the smallscreen optimisation
    return $enqueue_styles;
}
add_filter('woocommerce_enqueue_styles', 'dequeue_styles');

// Сортировка

function woocommerce_get_catalog_ordering_popular_args($args) {
    global $wp_query;
    if (isset($_GET['orderby'])) {
        switch ($_GET['orderby']) :
            case 'popularity_asc' :
                $args['orderby'] = 'meta_value';
                $args['order'] = 'ASC';
                $args['meta_key'] = 'total_sales';
                break;
            case 'popularity_desc' :
                $args['orderby'] = 'meta_value';
                $args['order'] = 'DESC';
                $args['meta_key'] = 'total_sales';
                break;
        endswitch;
    }
    return $args;
}
add_filter('woocommerce_get_catalog_ordering_args', 'woocommerce_get_catalog_ordering_popular_args');

function my_woocommerce_catalog_orderby($orderby) {
    unset($orderby["popularity"]);
    unset($orderby["date"]);
    unset($orderby["menu_order"]);
    $orderby['popularity_asc'] = 'Популярности &#8595;';
    $orderby['popularity_desc'] = 'Популярности &#8593;';
    $orderby['price-desc'] = 'Цене &#8595;';
    $orderby['price'] = 'Цене &#8593;';
    return $orderby;
}
add_filter("woocommerce_catalog_orderby", "my_woocommerce_catalog_orderby", 20);

// Убрать сортировку товаров
remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);

function misha_default_catalog_orderby($sort_by) {
    if (is_product_category() && isset($_COOKIE['ordering'])) {
        $case = $_COOKIE['ordering'];
        $trimmed = trim($case, '\"');
        switch ($trimmed) {
            case 'price-desc':
                return 'price-desc';
            case 'price':
                return 'price';
            case 'popularity_desc':
                return 'rand';
            default:
                return 'popularity';
        }
    }
}
add_filter('woocommerce_default_catalog_orderby', 'misha_default_catalog_orderby');

// sale products
function show_on_sale_products($query) {
    if (is_product_category()) {
        $on_sale = $_COOKIE['on_sale'];
        $trimmed = trim($on_sale, '\"');
    }
    if (is_product_category() && $query->is_main_query() && $query->query_vars['wc_query'] == 'product_query' && $trimmed == '1') {
        $query->set('meta_key', '_sale_price');
        $query->set('meta_value', '0');
        $query->set('meta_compare', '>=');
    }
}
if (isset($_COOKIE['on_sale'])) {
    add_action('pre_get_posts', 'show_on_sale_products');
}

// spicy products
function show_on_spicy_products($query){
    if (is_product_category()) {
        $is_spicy = $_COOKIE['is_spicy'];
        $trimmed = trim($is_spicy, '\"');
    }
    if (is_product_category() && $query->is_main_query() && $query->query_vars['wc_query'] == 'product_query' &&  $trimmed == '1' ) {
        $query->set('product_tag', 'spicy');
    }
}

if (isset($_COOKIE['is_spicy'])) {
    add_action('pre_get_posts', 'show_on_spicy_products');
}

function target_main_category_query_with_conditional_tags($query) {
    if (!is_admin() && $query->is_main_query()) {
        if ( is_category() ) {
            $query->set('posts_per_page', 12);
        }
    }
}

remove_action('woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20);
add_action('woocommerce_checkout_after_customer_details', 'woocommerce_checkout_payment', 20);


function custom_checkout_fields($array) {
    unset($array['billing']['billing_last_name']); // Фамилия
    unset($array['billing']['billing_email']); // Email
    unset($array['order']['order_comments']); // Примечание к заказу
    unset($array['billing']['billing_company']); // Компания
    unset($array['billing']['billing_country']); // Страна
    unset($array['billing']['billing_address_2']); // 2-ая строка адреса
    unset($array['billing']['billing_city']); // Населённый пункт
    unset($array['billing']['billing_state']); // Область / район
    unset($array['billing']['billing_postcode']); // Почтовый индекс

    unset($array['billing']['billing_phone']['validate']);
    unset($array['billing']['billing_address_1']['validate']);

    $array['billing']['billing_phone']['priority'] = 20;
    $array['billing']['billing_address_1']['priority'] = 30;

    $array['billing']['billing_first_name']['placeholder'] = 'ФИО';
    $array['billing']['billing_phone']['placeholder'] = 'Телефон';
    $array['billing']['billing_address_1']['placeholder'] = 'Адрес доставки';

    $array['billing']['billing_first_name']['label'] = ' ';
    $array['billing']['billing_phone']['label'] = ' ';
    $array['billing']['billing_address_1']['label'] = ' ';

    return $array;
}

add_filter('woocommerce_checkout_fields', 'custom_checkout_fields', 9999);

function checkout_fields_in_label_error($field, $key, $args, $value)
{
    if (strpos($field, '</label>') !== false && $args['required']) {
        $error = '<span class="error">';
        $error .= sprintf(__('Ошибка: Поле %s не заполнено', 'woocommerce'), $args['label']);
        $error .= '</span>';
        $field = substr_replace($field, $error, strpos($field, '</label>'), 0);
    }
    return $field;
}

add_filter('woocommerce_form_field', 'checkout_fields_in_label_error', 10, 4);
