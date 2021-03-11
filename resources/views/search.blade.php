@extends('layouts.app')

@section('content')
  {{woocommerce_breadcrumb()}}
  <div class="search-block">
    <div class="container">
      <h1 class="title">Поиск по запросу @php echo get_search_query() @endphp</h1>
      <div class="search-block__wrap">
        @if (!have_posts())
          <div class="alert alert-warning">
            {{ __('Извините, результатов не найдено', 'sage') }}
          </div>
        @endif
        {!! get_search_form(false) !!}
        <ul class="products columns-4">
          @while(have_posts()) @php the_post() @endphp
          @include('woocommerce.content-product')
          @endwhile
        </ul>
      </div>

      @php if ( function_exists( 'wp_corenavi' ) ) wp_corenavi(); @endphp
    </div>
  </div>
@endsection
