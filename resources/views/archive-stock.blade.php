@extends('layouts.app')

@section('content')

  <div class="actions-page">
    @php woocommerce_breadcrumb() @endphp
    <div class="container">
      <h1 class="title">Акции</h1>
      @php
        $args = [
          'post_type' => 'stock',
          'posts_per_page' => 6,
          'orderby' => 'date',
          'order'   => 'DESC',
          'post_status' => 'publish ',
        ];
      @endphp
      @php query_posts($args) @endphp
      @if(have_posts())
        <div class="actions__wrap">
          @while(have_posts()) @php the_post() @endphp
          @include('partials.actions-item')
          @endwhile
          @php wp_reset_query() @endphp
        </div>
      @endif
    </div>
  </div>
@endsection
