{{--
Template Name: Policy
--}}

@extends('layouts.app')

@section('content')
  {{woocommerce_breadcrumb()}}
  <div class="policy-page">
    <div class="container">
      <h1 class="title">{{the_title()}}</h1>
      {{the_content()}}
    </div>
  </div>
@endsection
