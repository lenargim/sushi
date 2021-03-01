@php
  $args = [
      'orderby' => 'date',
      'posts_per_page' => 3,
      'post_status' => 'publish',
      'order' => 'DESC',
      'post_type' => 'stock',
  ];
$loop = new WP_Query($args);
@endphp
@if ($loop)
  <section class="actions-main">
    <div class="label-back">
      Кухня<br>
      Кухня<br>
      Кухня<br>
      Кухня<br>
    </div>
    <div class="container">
      <div class="actions-main__wrap">
        @while($loop->have_posts()) @php $loop->the_post() @endphp
        @php $isImg = get_the_post_thumbnail_url() @endphp
        @php $style = $isImg ? "background: url(' " . $isImg . " ');" : "background: " . get_field('bg') . ";"  @endphp
        <div class="actions-main__item" style="@php echo $style @endphp">
          @if(get_field('isAction'))
            <a href="@php echo get_post_type_archive_link('stock') @endphp" class="actions-main__info">% Акция</a>
          @endif
          <span class="actions-main__title">{{the_title()}}</span>
          <span class="actions-main__desc">{{the_field('stock_short_desc')}}</span>
          <a href="{{the_permalink()}}" class="actions-main__more">Подробнее</a>
        </div>
        @endwhile
        @php(wp_reset_postdata())
      </div>
    </div>
  </section>
@endif
