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
  <div class="menu__sub">
    <div class="container">
      <div class="menu__sub-wrap">
        <a href="#zapechenye" class="menu__sub-item">Запеченые</a>
        <a href="#mini-rolly" class="menu__sub-item">Мини-роллы</a>
        <a href="#opalennye" class="menu__sub-item">Опаленные</a>
        <a href="#tempura" class="menu__sub-item">Темпура</a>
        <a href="#holodnye" class="menu__sub-item">Холодные роллы</a>
      </div>
    </div>
  </div>
</div>
