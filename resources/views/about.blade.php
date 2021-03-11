{{--
  Template Name: О нас
--}}

@extends('layouts.app')

@section('content')

  <div class="about">
    @php woocommerce_breadcrumb() @endphp
    <div class="container">
      <h1 class="title">{{ the_title() }}</h1>
      <div class="description">{{the_content()}}</div>
    </div>
  </div>
@endsection
