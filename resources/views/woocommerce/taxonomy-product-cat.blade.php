@extends('layouts.app')
@section('content')
  @php
    do_action('woocommerce_before_main_content');
  @endphp

  @if(apply_filters('woocommerce_show_page_title', true) && !is_product_category( 'rolls' ))
    <div class="container">
      <h1 class="title">{!! woocommerce_page_title(false) !!}</h1>
    </div>
  @endif
  <div class="container">
    <div class="label-back">
      {!! woocommerce_page_title(false) !!}<br>
      {!! woocommerce_page_title(false) !!}<br>
      {!! woocommerce_page_title(false) !!}<br>
      {!! woocommerce_page_title(false) !!}<br>
    </div>
    @if( !is_product_category( 'rolls' ) )
      <div class="interaction">
        <div class="ordering">
          <span class="ordering__title">Сортировка по:</span>
          <div class="select">
            <label><span>Популярности</span> @include('icon::order-arrow', ['class' => 'arrow'])</label>
            <div class="option__wrap">
              <a href="?orderby=popularity_desc" data-hash="popularity_desc"
                 class="option active"><span>Популярности</span> @include('icon::order-arrow', ['class' => 'arrow'])</a>
              <a href="?orderby=popularity_asc" data-hash="popularity_asc"
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
            <label for="sale-filter" class="label">Только со скидкой</label>
          </div>
          <div class="filters__item">
            <input type="checkbox" id="spicy-filter">
            <label for="spicy-filter" class="label">Острые</label>
          </div>
        </div>
      </div>
    @endif
  </div>

  @if( !is_product_category( 'rolls' ) )
    @if(woocommerce_product_loop() )
      <div class="category-page">
        <div class="container">
          <div class="category-page__block">
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
              @php do_action('woocommerce_no_products_found') @endphp
          </div>
        </div>
      </div>
    @endif
  @else
    <div class="category-page">
      <div class="container">
        @php
          $category = get_queried_object();
            $subcategories = woocommerce_get_product_subcategories($category->term_id);
        @endphp
        @foreach ($subcategories as $subcat)
          @php
            $loop = new WP_Query( [
             'post_type' => 'product',
             'product_cat' => $subcat->slug,
             'post_parent' => $category->id,
             'posts_per_page' => -1,
             'orderby' => 'menu_order',
             'order' => 'ASC'
             ]);
          @endphp
          <h2 class="title" id="@php echo $subcat->slug @endphp">@php echo $subcat->name  @endphp</h2>
          <div class="category-page__rolls category-page__block">
            @php woocommerce_product_loop_start() @endphp
            @while ( $loop->have_posts() )
              @php
                $loop->the_post();
                do_action('woocommerce_shop_loop');
                wc_get_template_part('content', 'product');
                wp_reset_postdata();
              @endphp
            @endwhile
            @php woocommerce_product_loop_end() @endphp
          </div>
        @endforeach
      </div>
    </div>
  @endif
  @include('partials.map')
  @include('partials.shipping')
  @php
    do_action('woocommerce_after_main_content');
    do_action('get_sidebar', 'shop');
    do_action('get_footer', 'shop');
  @endphp
@endsection
