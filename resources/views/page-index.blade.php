{{--
Template Name: Главная
--}}

@extends('layouts.app')

@section('content')
  @include('partials.actions')
  @include('partials.popular')
  @include('partials.assortment')
  @include('partials.map')
  @include('partials.shipping')
@endsection
