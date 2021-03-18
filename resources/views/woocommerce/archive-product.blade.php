{{--
The Template for displaying product archives, including the main shop page which is a post type archive
This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
HOWEVER, on occasion WooCommerce will need to update template files and you
(the theme developer) will need to copy the new files to your theme to
maintain compatibility. We try to do this as little as possible, but it does
happen. When this occurs the version of the template file will be bumped and
the readme will list any important changes.
@see https://docs.woocommerce.com/document/template-structure/
@package WooCommerce/Templates
@version 3.4.0
--}}

@extends('layouts.app')

@section('content')
  @php
    do_action('get_header', 'shop');
    do_action('woocommerce_before_main_content');
  @endphp

  @if(apply_filters('woocommerce_show_page_title', true))
    <div class="container">
      <h1 class="title">{!! woocommerce_page_title(false) !!}</h1>
    </div>
  @endif
  <div class="main-page">
    <div class="label-back">
      Кухня<br>
      Кухня<br>
      Кухня<br>
      Кухня<br>
    </div>
    @include('partials.assortment')
  </div>
  @include('partials.map')
  @include('partials.shipping')
  @php
    do_action('woocommerce_after_main_content');
    do_action('get_sidebar', 'shop');
    do_action('get_footer', 'shop');
  @endphp
@endsection
