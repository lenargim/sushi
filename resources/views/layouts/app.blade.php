<!doctype html>
<html {!! get_language_attributes() !!}>
@include('partials.head')
<body @php body_class() @endphp>
@php do_action('get_header') @endphp
@if(!is_product_category())
  @include('partials.header')
  @elseif( !is_product_category( 'rolls' ) )
  @include('partials.header-category')
  @else
  @include('partials.header-extended')
@endif
<div class="wrap" role="document">
  <main class="main">
    @yield('content')
  </main>
  @if (App\display_sidebar())
    <aside class="sidebar">
      @include('partials.sidebar')
    </aside>
  @endif
</div>
@php do_action('get_footer') @endphp
@include('partials.footer')
@php wp_footer() @endphp
</body>
</html>
