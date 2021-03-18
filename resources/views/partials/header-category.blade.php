<div class="menu">
  <div class="container">
    <div class="menu__wrap">
      {{ wp_nav_menu(['menu' => 'Shop', 'menu_class' => 'menu__list', 'container' => false]) }}
      <a href="/cart" class="menu__cart-wrap">
        @include('icon::cart', ['class' => 'menu__cart-svg'])
        @if(WC()->cart->get_cart_contents_count())
          <span class="menu__cart-amount">@php echo WC()->cart->get_cart_contents_count() @endphp</span>
        @endif
        <span class="menu__cart-total"> @php echo WC()->cart->cart_contents_total @endphp руб</span>
      </a>
    </div>
  </div>
  <div class="menu__mobile"></div>
</div>
