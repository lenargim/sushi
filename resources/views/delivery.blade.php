{{--
  Template Name: Delivery
--}}

@extends('layouts.app')

@section('content')

  <div class="delivery">
    @php woocommerce_breadcrumb() @endphp
    <div class="container">
      <h1 class="title">{{ the_title() }}</h1>
      <div class="description"><p>Кое-что полезное написали для вас под картой зон доставки 👇</p></div>
    </div>
    @include('partials.map')
    <div class="container">
      <div class="description">{{the_content()}}</div>
    </div>
  </div>
@endsection
