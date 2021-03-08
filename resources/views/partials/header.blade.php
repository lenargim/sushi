<header class="header">
  <div class="container">
    <div class="header__wrap">
      <a class="header__logo" href="{{ home_url('/') }}"><img src="@asset('images/logo.png')" alt="logo"></a>
      <nav class="nav-primary">
        @if (has_nav_menu('primary_navigation'))
          {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav', 'container' => false]) !!}
        @endif
      </nav>
      <div class="header__info">
        <a class="header__phone" href="tel:@php the_field('phone',8) @endphp">@php the_field('phone',8) @endphp</a>
        <span>@php the_field('working-hours',8) @endphp</span>
      </div>
      <div class="header__socials">
        <a href="https://vk.com/@php the_field('vk',8) @endphp" target="_blank">
          @include('icon::vk', ['class' => 'icon'])
        </a>
        <a href="https://www.instagram.com/@php the_field('instagram',8) @endphp" target="_blank">
          @include('icon::instagram', ['class' => 'icon'])
        </a>
      </div>
    </div>
</header>
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
</div>
