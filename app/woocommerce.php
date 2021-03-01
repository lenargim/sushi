<?php
//add_filter('woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment');
add_filter('woocommerce_add_to_cart_fragments', 'woocommerce_content_add_to_cart_fragment');

function woocommerce_header_add_to_cart_fragment($fragments)
{
    ob_start();
    ?>
    <a href="/cart" class="menu__cart-wrap">
        <svg class="cart" width="39" height="39" viewBox="0 0 39 39" fill="none" xmlns="http://www.w3.org/2000/svg">
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

function woocommerce_content_add_to_cart_fragment($fragments){
    global $product;
    ob_start();
    ?>
    <div class="product__changable">
        <?php
        $targeted_id = $product->get_id();
        var_dump($targeted_id);
        // Get quantities for each item in cart (array of product id / quantity pairs)
        $quantities = WC()->cart->get_cart_item_quantities();
        ?>
        <div class="product__amount" data-id="<?php echo $targeted_id ?>">
            <div class="product__button minus">-</div>
            <input class="product__quantity" type="number" readonly value="<?php echo $quantities[$targeted_id] ?>">
            <div class="product__button plus">+</div>
        </div>
    </div>
    <?php
    $fragments['div.product__changable'] = ob_get_clean();
    return $fragments;
}
