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
        <span class="menu__cart-total"><span><?php echo WC()->cart->cart_contents_total ?></span> руб</span>
    </a>
    <?php
    $fragments['a.menu__cart-wrap'] = ob_get_clean();
    return $fragments;
}

add_filter('woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment');

function woocommerce_cart_total_fragment($fragments)
{
    ob_start();
    ?>
    <div class="cart__info">
        <?php
        $discount_total = 0;

        foreach ( WC()->cart->get_cart() as $cart_item_key => $values ) {
            $product = $values['data'];
            if ( $product->is_on_sale() ) {
                $regular_price = $product->get_regular_price();
                $sale_price = $product->get_sale_price();
                $discount = ( $regular_price - $sale_price ) * $values['quantity'];
                $discount_total += $discount;
            }
        }
        ?>
        <div>
            <div class="cart__info-row">
                <span>Скидка:</span>
                <span><?php echo $discount_total . " ₽" ?></span>
            </div>
            <div class="cart__info-row">
                <span>Итого:</span>
                <span> <?php wc_cart_totals_order_total_html() ?></span>
            </div>
        </div>
        <div class="wc-proceed-to-checkout">
        </div>
        <?php do_action('woocommerce_proceed_to_checkout'); ?>
    </div>
    <?php
    $fragments['div.cart__info'] = ob_get_clean();
    return $fragments;
}

add_filter('woocommerce_add_to_cart_fragments', 'woocommerce_cart_total_fragment');

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


function my_remove_product_result_count()
{
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

function woocommerce_get_catalog_ordering_popular_args($args)
{
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

function my_woocommerce_catalog_orderby($orderby)
{
    unset($orderby["popularity"]);
    unset($orderby["date"]);
    unset($orderby["menu_order"]);
    $orderby['popularity_desc'] = 'Популярности &#8593;';
    $orderby['popularity_asc'] = 'Популярности &#8595;';
    $orderby['price-desc'] = 'Цене &#8595;';
    $orderby['price'] = 'Цене &#8593;';
    return $orderby;
}

add_filter("woocommerce_catalog_orderby", "my_woocommerce_catalog_orderby", 20);

// Убрать сортировку товаров
remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);

// sale products
function show_on_sale_products($query)
{
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
function show_on_spicy_products($query)
{
    if (is_product_category()) {
        $is_spicy = $_COOKIE['is_spicy'];
        $trimmed = trim($is_spicy, '\"');
    }
    if (is_product_category() && $query->is_main_query() && $query->query_vars['wc_query'] == 'product_query' && $trimmed == '1') {
        $query->set('product_tag', 'spicy');
    }
}

if (isset($_COOKIE['is_spicy'])) {
    add_action('pre_get_posts', 'show_on_spicy_products');
}

function target_main_category_query_with_conditional_tags($query)
{
    if (!is_admin() && $query->is_main_query()) {
        if (is_category()) {
            $query->set('posts_per_page', 12);
        }
    }
}

remove_action('woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20);
add_action('woocommerce_checkout_after_customer_details', 'woocommerce_checkout_payment', 20);


function custom_checkout_fields($array)
{
    unset($array['billing']['billing_last_name']); // Фамилия
    unset($array['billing']['billing_email']); // Email
    unset($array['billing']['billing_company']); // Компания
    unset($array['billing']['billing_city']); // Населённый пункт
    unset($array['billing']['billing_state']); // Область / район
    unset($array['billing']['billing_postcode']); // Почтовый индекс
    unset($array['shipping']['shipping_first_name']);
    unset($array['shipping']['shipping_addres_1']);
    unset($array['shipping']['shipping_last_name']);
    unset($array['shipping']['shipping_company']);
    unset($array['shipping']['shipping_city']);
    unset($array['shipping']['shipping_state']);
    unset($array['shipping']['shipping_postcode']);

//    unset($array['billing']['billing_phone']['validate']);
//    unset($array['billing']['billing_address_1']['validate']);
    $array['billing']['billing_address_1']['required'] = true;
    $array['billing']['billing_address_2']['required'] = true;

    $array['billing']['billing_phone']['priority'] = 20;
    $array['billing']['billing_address_1']['priority'] = 30;
    $array['billing']['billing_address_1']['label'] = 'Выберите адрес из выпадающей строки';
    $array['billing']['billing_address_2']['label'] = '&nbsp;';
    $array['billing']['billing_address_1']['label_class'] = 'address-label';
    $array['billing']['billing_address_2']['label_class'] = 'address-label';
    $array['billing']['billing_address_1']['class'] = ['width-85'];
    $array['billing']['billing_address_2']['class'] = ['width-15'];
    $array['billing']['billing_address_2']['priority'] = 40;
    $array['billing']['entrance']['priority'] = 41;
    $array['billing']['floor']['priority'] = 42;
    $array['billing']['billing_address_2']['placeholder'] = 'Кв.';
    $array['billing']['billing_country']['priority'] = 50;
    $array['billing']['billing_country']['contenteditable'] = false;
    $array['billing']['billing_first_name']['placeholder'] = 'Имя';
    $array['billing']['billing_phone']['placeholder'] = 'Телефон';
    $array['billing']['billing_first_name']['label'] = 'Имя';
    $array['billing']['billing_phone']['label'] = 'Телефон';
    $array['billing']['billing_country']['type'] = 'text';
    $array['shipping']['shipping_country']['label'] = 'Зона доставки';
    $array['order']['order_comments']['placeholder'] = 'Комментарий к заказу';

    return $array;
}

add_filter('woocommerce_checkout_fields', 'custom_checkout_fields', 9999);

//function uwc_new_address_one_placeholder( $fields ) {
//    $fields['address_1']['placeholder'] = 'Адрес доставки';
//    $fields['address_2']['placeholder'] = 'Кв';
//    $fields['address_1']['label'] = 'Адрес доставки';
//    $fields['address_2']['label'] = 'Квартира';
//
//    return $fields;
//}
//add_filter( 'woocommerce_default_address_fields', 'uwc_new_address_one_placeholder' );

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

function wc_short_description($product, $length) {
    $desc = $product->get_short_description();
    if (strlen($desc) < $length) {
        return $desc;
    } else {
        return mb_substr($desc, 0, $length-1, 'UTF-8') . '...';
    }
}

add_action( 'woocommerce_checkout_order_created', 'telegram_bot', 20, 1 );
function telegram_bot( $order ) {
    $name = $order->billing_first_name;
    $phone = $order->get_billing_phone();
    $phoneLink = urlencode($phone);
    $address1 = $order->billing_address_1;
    $address2 = $order->billing_address_2;
    $address = $address1 . ', ' . $address2;
    $floor = get_post_meta( $order->get_id(), 'floor', true );
    if ($floor == '') $floor = 'Не указан';
    $entrance = get_post_meta( $order->get_id(), 'entrance', true );
    if ($entrance == '') $entrance = 'Не указан';
    $additionalAddress = 'Подъезд: ' . $entrance . '. Этаж: ' . $floor;
    if ($order->get_used_coupons()) {
        $coupon = $order->get_used_coupons()[0];
    } else {
        $coupon = 'Купон не применен';
    }
    $shisha = get_post_meta( $order->get_id(), 'shisha', true );
    if ($shisha == '') $shisha = 'Не указано';
    $comment = $order->customer_message;
    $delivery = $order->get_shipping_total() . ' ₽';
    $total = $order->get_total() . ' ₽';
    $paymethod = $order->get_payment_method_title();
    $token = "1780531821:AAEwdkJeNWlrsN4vckWE7ZJaV_YDetljpEo";
    $chat_id = "-400699790";
    $collect = "%0A";
    foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
        $_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
        $_product->get_name();
        $cart_item['quantity'];
        $collect .= "<b>-".$_product->get_name() . ": " . $cart_item['quantity'] . "шт.</b>%0A";
    }
    $arr = [
        'Имя:' => $name,
        'Телефон:' => $phoneLink,
        'Адрес:' => $address,
        'Доп. адрес:' => $additionalAddress,
        'Комментарий:' => $comment,
        'Доставка:' => $delivery,
        'Сумма:' => $total,
        'Оплата:' => $paymethod,
        'Купон:' => $coupon,
        'Кальян' => $shisha,
        'Заказ:' => $collect,
    ];
    foreach($arr as $key => $value) {
        $txt .= "<b>".$key."</b> ".$value."%0A";
    };
    $sendToTelegram = fopen("https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chat_id}&parse_mode=html&text={$txt}","r");
}

add_action( 'wp_enqueue_scripts', 'my_scripts_method' );
function my_scripts_method() {
    wp_register_script( 'dadata', 'https://cdn.jsdelivr.net/npm/suggestions-jquery@20.3.0/dist/js/jquery.suggestions.min.js');
    wp_enqueue_script('dadata');
    wp_enqueue_style( 'dadata-style', 'https://cdn.jsdelivr.net/npm/suggestions-jquery@20.3.0/dist/css/suggestions.min.css' );
    wp_enqueue_script('dadata-style');
    wp_register_script( 'yandexapi', 'https://api-maps.yandex.ru/2.1/?apikey=f23778e3-4bf9-42c8-b7fa-87e8712c323e&lang=ru_RU');
    wp_enqueue_script('yandexapi');
}

add_filter( 'woocommerce_countries',  'truemisha_add_new_country' );

function truemisha_add_new_country( $countries ) {

    $new_countries = array(
        'ZN1' => 'Зеленая зона',
        'ZN2' => 'Оранжевая зона',
        'ZN3' => 'Синяя зона',
        'ZN4' => 'Розовая зона',
    );

    return array_merge( $countries, $new_countries );

}

add_filter( 'woocommerce_continents', 'truemisha_add_new_country_to_continents' );

function truemisha_add_new_country_to_continents( $continents ) {

    $continents[ 'EU' ][ 'countries' ][] = 'ZN1';
    $continents[ 'EU' ][ 'countries' ][] = 'ZN2';
    $continents[ 'EU' ][ 'countries' ][] = 'ZN3';
    $continents[ 'EU' ][ 'countries' ][] = 'ZN4';
    return $continents;
}

function my_hide_shipping_when_free_is_available( $rates ) {
    $free = array();
    foreach ( $rates as $rate_id => $rate ) {
        if ( 'free_shipping' === $rate->method_id ) {
            $free[ $rate_id ] = $rate;
            break;
        }
    }
    return ! empty( $free ) ? $free : $rates;
}
add_filter( 'woocommerce_package_rates', 'my_hide_shipping_when_free_is_available', 100 );


function get_free_shipping_minimum($zone_name = 'RU') {
    if ( ! isset( $zone_name ) ) return null;

    $result = null;
    $zone = null;
    $zones = WC_Shipping_Zones::get_zones();
    foreach ( $zones as $z ) {
        if ( $z['zone_name'] == $zone_name ) {
            $zone = $z;
        }
    }
    if ( $zone ) {
        $shipping_methods_nl = $zone['shipping_methods'];
        $free_shipping_method = null;
        foreach ( $shipping_methods_nl as $method ) {
            if ( $method->id == 'free_shipping' ) {
                $free_shipping_method = $method;
                break;
            }
        }
        if ( $free_shipping_method ) {
            $result = $free_shipping_method->min_amount;
        }
    }
    return $result;
}

function my_account_menu_order() {
    $menuOrder = array(
        'dashboard'          => __( 'Личные данные', 'woocommerce' ),
        'favorites'          => __( 'Избранное', 'woocommerce' ),
        'orders'             => __( 'Мои заказы', 'woocommerce' ),
        'customer-logout'    => __( 'Выйти', 'woocommerce' ),
    );
    return $menuOrder;
}
add_filter ( 'woocommerce_account_menu_items', 'my_account_menu_order' );

add_filter ( 'woocommerce_account_menu_items', 'account_favorites', 20 );
function account_favorites( $menu_links ){
    $menu_links = array_slice( $menu_links, 0, 5, true )
        + array( 'favorites' => 'Избранное' )
        + array_slice( $menu_links, 5, NULL, true );

    return $menu_links;

}
add_action( 'init', 'misha_add_endpoint' );
function misha_add_endpoint() {
    add_rewrite_endpoint( 'favorites', EP_PAGES );

}
add_action( 'woocommerce_account_favorites_endpoint', 'misha_my_account_endpoint_content' );
function misha_my_account_endpoint_content() {
    include_once get_template_directory() . '\views\woocommerce\myaccount\favorites.php';
}

add_action( 'woocommerce_save_account_details_errors','billing_phone_field_validation', 20, 1 );
function billing_phone_field_validation( $args ){
    if ( isset($_POST['billing_phone']) && empty($_POST['billing_phone']) )
        $args->add( 'error', __( 'Please fill in your Mobile phone', 'woocommerce' ),'');
}


function my_account_saving_billings_data( $user_id )
{
    if (isset($_POST['billing_phone']) && !empty($_POST['billing_phone'])) {
        update_user_meta($user_id, 'billing_phone', sanitize_text_field($_POST['billing_phone']));
    }
    if (isset($_POST['billing_address_1']) && !empty($_POST['billing_address_1'])) {
        update_user_meta($user_id, 'billing_address_1', sanitize_text_field($_POST['billing_address_1']));
    }

    if (isset($_POST['billing_address_2']) && !empty($_POST['billing_address_2'])) {
        update_user_meta($user_id, 'billing_address_2', sanitize_text_field($_POST['billing_address_2']));
    }
}

add_action( 'woocommerce_save_account_details', 'my_account_saving_billings_data', 20, 1 );


add_filter('woocommerce_save_account_details_required_fields', 'wc_save_account_details_required_fields' );
function wc_save_account_details_required_fields( $required_fields ){
    unset( $required_fields['account_display_name'] );
    unset( $required_fields['account_last_name'] );
    unset( $required_fields['account_email'] );
    $required_fields['billing_phone'];
    return $required_fields;
}

add_filter( 'woocommerce_checkout_fields' , 'custom_checkout_floor_field' );

function custom_checkout_floor_field( $fields ) {
    $fields['billing']['entrance'] = array(
        'type'          => 'text', // text, textarea, select, radio, checkbox, password, about custom validation a little later
        'required'	=> false, // actually this parameter just adds "*" to the field
        'class'         => array('order-textarea', 'form-row-wide width-50'), // array only, read more about classes and styling in the previous step
        'placeholder'       => 'Подъезд',
    );
    $fields['billing']['floor'] = array(
        'type'          => 'text', // text, textarea, select, radio, checkbox, password, about custom validation a little later
        'required'	=> false, // actually this parameter just adds "*" to the field
        'class'         => array('order-textarea', 'form-row-wide width-50 width-50_right'), // array only, read more about classes and styling in the previous step
        'placeholder'       => 'Этаж',
    );

    $fields['billing']['shisha'] = array(
        'type'          => 'text', // text, textarea, select, radio, checkbox, password, about custom validation a little later
        'required'	=> false, // actually this parameter just adds "*" to the field
        'class'         => array('order-textarea', 'form-row-wide hidden'), // array only, read more about classes and styling in the previous step
        'placeholder'       => '',
    );

    return $fields;
}

add_action( 'woocommerce_checkout_update_order_meta', 'floor_update_order_meta' );

function floor_update_order_meta( $order_id ) {
    if ( ! empty( $_POST['entrance'] ) ) {
        update_post_meta( $order_id, 'entrance',  wc_clean( $_POST[ 'entrance' ] ) );
    }
    if ( ! empty( $_POST['floor'] ) ) {
        update_post_meta( $order_id, 'floor',  wc_clean( $_POST[ 'floor' ] ) );
    }
    if ( ! empty( $_POST['shisha'] ) ) {
        update_post_meta( $order_id, 'shisha',  wc_clean( $_POST[ 'shisha' ] ) );
    }
}

add_action( 'woocommerce_admin_order_data_after_billing_address', 'custom_field_display_admin_order_meta', 10, 1 );

function custom_field_display_admin_order_meta($order){
    echo '<p><strong>'.__('Подъезд').':</strong><br> ' . get_post_meta( $order->get_id(), 'entrance', true ) . '</p>';
    echo '<p><strong>'.__('Этаж').':</strong><br> ' . get_post_meta( $order->get_id(), 'floor', true ) . '</p>';
}

add_filter( 'woocommerce_email_order_meta_fields', 'custom_woocommerce_email_order_meta_fields', 10, 3 );

function custom_woocommerce_email_order_meta_fields( $fields, $sent_to_admin, $order ) {
    $fields['entrance'] = array(
        'label' => __( 'Подъезд' ),
        'value' => get_post_meta( $order->id, 'entrance', true ),
    );
    $fields['floor'] = array(
        'label' => __( 'Этаж' ),
        'value' => get_post_meta( $order->id, 'floor', true ),
    );
    return $fields;
}

