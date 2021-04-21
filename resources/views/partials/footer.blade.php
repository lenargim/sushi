<footer class="footer">
  <div class="container">
    <div class="footer__wrap">
      <a class="footer__logo" href="{{ home_url('/') }}"><img src="@asset('images/logo.png')" alt="logo"></a>
      {{ wp_nav_menu(['menu' => 'Footer', 'menu_class' => 'footer__list', 'container' => false]) }}
      <div class="footer__info">
        <a class="footer__phone" href="tel:@php the_field('phone',8) @endphp">@php the_field('phone',8) @endphp</a>
        <span class="footer__work-hours">@php the_field('working-hours',8) @endphp</span>
        <div class="footer__address">
          @if(have_rows('addresses', 8))
            @while(have_rows('addresses', 8)) @php the_row() @endphp
            <span>@php the_sub_field('address') @endphp</span>
            @endwhile
          @endif
        </div>
        <div class="footer__socials">
          <a class="footer__socials-link" href="https://vk.com/@php the_field('vk',8) @endphp" target="_blank">
            @include('icon::vk', ['class' =>'footer-icon'])
          </a>
          <a class="footer__socials-link" href="tg://resolve?domain=@php the_field('telegram',8) @endphp" target="_blank">
            @include('icon::telegram', ['class' => 'footer-icon'])
          </a>
          <a class="footer__socials-link" href="https://www.instagram.com/@php the_field('instagram',8) @endphp" target="_blank">
            @include('icon::instagram', ['class' =>'footer-icon'])
          </a>
          <a class="footer__socials-link" href="https://api.whatsapp.com/send?phone=@php the_field('viber',8) @endphp" target="_blank">
            @include('icon::whatsapp', ['class' => 'footer-icon'])
          </a>
          <a class="footer__socials-link" href="viber://chat?number=%2B@php the_field('viber',8) @endphp" target="_blank">
            @include('icon::viber', ['class' => 'footer-icon'])
          </a>
        </div>
        <div class="footer__payments">
          <img src="@asset('images/visa.png')" alt="visa">
          <img src="@asset('images/mc.png')" alt="master card">
          <img src="@asset('images/cber.png')" alt="cber">
        </div>
      </div>
      <div class="footer__copy">
        <div>© 2021 ХОРОСЁ.<br>Все права защищены.<br>Сайт не является публичной<br> офертой.</div>
        <a href="@php echo get_page_link('3') @endphp"><span class="policy">Политика обработки<br> персональных данных</span></a>
      </div>
    </div>
  </div>
</footer>
<div class="overlay"></div>

<div class="to-top">
  @include('icon::to-top')
</div>
