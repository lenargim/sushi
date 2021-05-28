<header class="header @if(is_product_category()) hidden @endif">
  <div class="container">
    <div class="header__wrap">
      <div class="header__mobile">
        <div class="header__more"><span></span></div>
      </div>
      <a class="header__logo" href="{{ home_url('/') }}"><img src="@asset('images/logo.png')" alt="logo"></a>
      <nav class="nav-primary">
        @if (has_nav_menu('primary_navigation'))
          {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav', 'container' => false]) !!}
        @endif
      </nav>
      <div class="header__info">
        <a class="header__phone" href="tel:@php the_field('phone',8) @endphp">
          <span>@php the_field('phone',8) @endphp</span>
        </a>
        <span>@php the_field('working-hours',8) @endphp</span>
      </div>
      <div class="header__socials">
        <a class="header__socials-link" href="https://vk.com/@php the_field('vk',8) @endphp" target="_blank">
          @include('icon::vk', ['class' => 'icon'])
        </a>
        <a class="header__socials-link" href="tg://resolve?domain=@php the_field('telegram',8) @endphp" target="_blank">
          @include('icon::telegram', ['class' => 'icon'])
        </a>
        <a class="header__socials-link" href="https://www.instagram.com/@php the_field('instagram',8) @endphp" target="_blank">
          @include('icon::instagram', ['class' => 'icon'])
        </a>
        <a class="header__socials-link" href="https://api.whatsapp.com/send?phone=@php the_field('viber',8) @endphp" target="_blank">
          @include('icon::whatsapp', ['class' => 'icon'])
        </a>
        <a class="header__socials-link" href="viber://chat?number=%2B@php the_field('viber',8) @endphp" target="_blank">
          @include('icon::viber', ['class' => 'icon'])
        </a>
      </div>
      <div class="header__account-block">
        <div class="header__search">
          @include('icon::search', ['class' => 'icon header__search-svg'])
          @include('searchform')
          @include('icon::search-close', ['class' => 'icon header__search-close'])
        </div>
        <a class="header__phone-mobile" href="tel:@php the_field('phone',8) @endphp">
          @include('icon::phone', ['class' => 'icon-mobile mobile'])
        </a>
      </div>
    </div>
  </div>
</header>
<div class="menu">
  <div class="container">
    <div class="menu__wrap">
      @if (!wp_is_mobile())
        {{ wp_nav_menu(['menu' => 'Shop', 'menu_class' => 'menu__list', 'container' => false]) }}
        <a href="/cart" class="menu__cart-wrap">
          @include('icon::cart', ['class' => 'menu__cart-svg'])
          @if(WC()->cart->get_cart_contents_count())
            <span class="menu__cart-amount">@php echo WC()->cart->get_cart_contents_count() @endphp</span>
          @endif
          <span class="menu__cart-total"> <span> @php echo WC()->cart->cart_contents_total @endphp</span> руб</span>
        </a>
        @else
        <div class="menu__mobile-cart-wrap">
          <a href="/cart" class="menu__cart-wrap">
            @include('icon::cart', ['class' => 'menu__cart-svg'])
            @if(WC()->cart->get_cart_contents_count())
              <span class="menu__cart-amount">@php echo WC()->cart->get_cart_contents_count() @endphp</span>
            @endif
            <span class="menu__cart-total"> <span> @php echo WC()->cart->cart_contents_total @endphp</span> руб</span>
          </a>
        </div>
        {{ wp_nav_menu(['menu' => 'mobile-submenu', 'menu_class' => 'menu__list', 'container' => false]) }}
      @endif
    </div>
  </div>
  <div class="menu__mobile">
      {!! wp_nav_menu(['menu' => 'mobile-menu', 'menu_class' => 'nav']) !!}
    <div class="header__socials">
      <span>@php the_field('working-hours',8) @endphp</span>
    </div>
    <div class="header__socials">
      <a class="header__socials-link" href="https://vk.com/@php the_field('vk',8) @endphp" target="_blank">
        @include('icon::vk', ['class' => 'icon'])
      </a>
      <a class="header__socials-link" href="tg://resolve?domain=@php the_field('telegram',8) @endphp" target="_blank">
        @include('icon::telegram', ['class' => 'icon'])
      </a>
      <a class="header__socials-link" href="https://www.instagram.com/@php the_field('instagram',8) @endphp" target="_blank">
        @include('icon::instagram', ['class' => 'icon'])
      </a>
      <a class="header__socials-link" href="https://api.whatsapp.com/send?phone=@php the_field('viber',8) @endphp" target="_blank">
        @include('icon::whatsapp', ['class' => 'icon'])
      </a>
      <a class="header__socials-link" href="viber://chat?number=%2B@php the_field('viber',8) @endphp" target="_blank">
        @include('icon::viber', ['class' => 'icon'])
      </a>
    </div>
  </div>
  @if(is_product_category('rolls'))
  <div class="menu__sub">
    <div class="container">
      <div class="menu__sub-wrap">
        <a href="#mini-rolly" class="menu__sub-item">Мини-роллы</a>
        <a href="#holodnye" class="menu__sub-item">Холодные роллы</a>
        <a href="#zapechenye" class="menu__sub-item">Запеченые</a>
        <a href="#opalennye" class="menu__sub-item">Опаленные</a>
        <a href="#tempura" class="menu__sub-item">Темпура</a>
      </div>
    </div>
  </div>
  @endif
</div>
