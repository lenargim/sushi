<section class="shipping">
  <div class="container">
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
      <h2 class="title">{{the_field('block-title',8)}}</h2>
      <div class="description">{{the_field('block-description',8)}}</div>
      <div class="shipping__wrap">
        @while($loop->have_posts()) @php $loop->the_post() @endphp
        <div class="shipping__item">
          @if(get_field('small-img'))
            <img class="shipping__logo" src="{{the_field('small-img')}}" alt="{{the_title()}}">
            @else
            @include('icon::sushi', ['class' => 'shipping__logo'])
          @endif
          <div class="shipping__price">{{the_title()}}</div>
          <div class="shipping__info">{{the_field('stock_short_desc')}}</div>
        </div>
        @endwhile
        @php(wp_reset_postdata())
      </div>
    @endif
  </div>
</section>
