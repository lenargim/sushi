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
      <div class="actions__wrap">
        @while($loop->have_posts()) @php $loop->the_post() @endphp
          @include('partials.actions-item')
        @endwhile
        @php(wp_reset_postdata())
      </div>
    </div>
  </section>
@endif
