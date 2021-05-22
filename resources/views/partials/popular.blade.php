<section class="popular">
  <div class="label-back">
    Хиты<br>
    Хиты<br>
    Хиты<br>
    Хиты<br>
  </div>
  <div class="container">
    <div class="popular__wrap">
      <h2 class="title">Популярные товары</h2>
      <div class="description">Скидки до 20%</div>
      <div class="popular__slider slider">
        @php
          $args = [
          'post_type'       => 'product',
          'posts_per_page'  => 8,
          'meta_key'        => 'total_sales',
          'orderby'         => 'meta_value_num',
          ];
          $popular = new WP_Query($args);
        @endphp
        @if ($popular->have_posts())
          @while($popular->have_posts()) @php $popular->the_post() @endphp
        <div class="product__wrap">@php wc_get_template_part( 'content', 'product' ); @endphp</div>
          @endwhile
          @php(wp_reset_postdata())
        @endif
      </div>
    </div>
  </div>
</section>
