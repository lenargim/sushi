{{--
The Template for displaying product archives, including the main shop page which is a post type archive
This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
HOWEVER, on occasion WooCommerce will need to update template files and you
(the theme developer) will need to copy the new files to your theme to
maintain compatibility. We try to do this as little as possible, but it does
happen. When this occurs the version of the template file will be bumped and
the readme will list any important changes.
@see https://docs.woocommerce.com/document/template-structure/
@package WooCommerce/Templates
@version 3.4.0
--}}

@extends('layouts.app')

@section('content')
  @php
    do_action('get_header', 'shop');
    do_action('woocommerce_before_main_content');
  @endphp

  @if(apply_filters('woocommerce_show_page_title', true))
    <div class="container">
      <h1 class="title">{!! woocommerce_page_title(false) !!}</h1>
    </div>
  @endif
  @if( is_shop() )
    <div class="main-page">
      @include('partials.assortment')
      @include('partials.map')
      @include('partials.shipping')
    </div>
  @else
    <div class="container">
      <div class="interaction">
        <div class="ordering">
          <span>Сортировка по:</span>
          <div class="select">
            <label><span>Популярности</span> @include('icon::order-arrow', ['class' => 'arrow'])</label>
            <div class="option__wrap">
              <a href="?orderby=popularity_asc" data-hash="popularity_asc"
                 class="option active"><span>Популярности</span> @include('icon::order-arrow', ['class' => 'arrow'])</a>
              <a href="?orderby=popularity_desc" data-hash="popularity_desc"
                 class="option"><span>Популярности</span> @include('icon::order-arrow', ['class' => 'arrow rotate'])</a>
              <a href="?orderby=price-desc" data-hash="price-desc"
                 class="option"><span>Цене</span> @include('icon::order-arrow', ['class' => 'arrow'])</a>
              <a href="?orderby=price" data-hash="price"
                 class="option"><span>Цене</span> @include('icon::order-arrow', ['class' => 'arrow rotate'])</a>
            </div>
          </div>
        </div>
        <div class="filters">
          <div class="filters__item">
            <input type="checkbox" id="sale-filter">
            <label for="sale-filter">Только со скидкой</label>
          </div>
        </div>
      </div>
    </div>

    @if(woocommerce_product_loop())
      <div class="category-page">
        <div class="container">
          @php
            do_action('woocommerce_before_shop_loop');
            woocommerce_product_loop_start();
          @endphp
          @if(wc_get_loop_prop('total'))
            @while(have_posts())
              @php
                the_post();
                do_action('woocommerce_shop_loop');
                wc_get_template_part('content', 'product');
              @endphp
            @endwhile
          @endif

          @php
            woocommerce_product_loop_end();
            do_action('woocommerce_after_shop_loop');
          @endphp
          @else
            @php
              do_action('woocommerce_no_products_found');
            @endphp
        </div>
      </div>
    @endif
  @endif
  @php
    do_action('woocommerce_after_main_content');
    do_action('get_sidebar', 'shop');
    do_action('get_footer', 'shop');
  @endphp
@endsection
