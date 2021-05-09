@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp
  @php woocommerce_breadcrumb() @endphp
  <div class="action-detailed">
    <div class="container">
      <div class="action-detailed__wrap">
        <div class="action-detailed__main">
          <h1 class="title">{{the_title()}}</h1>
          @if( the_post_thumbnail() )
            {{the_post_thumbnail()}}
          @endif
          <div class="action-detailed__duration">
            <span>Срок акции: </span>
            <span class="orange">@php the_field('stock_duration') @endphp</span>
          </div>
          <div class="action-detailed__content">{{the_content()}}</div>
        </div>
        <aside class="sidebar">
          @php
            global $post;
            $args = [
            'post_type' => 'stock',
            'numberposts' => 2,
            'orderby' => 'date',
            'order'   => 'DESC',
            'exclude' => get_the_ID(),
            'post_status' => 'publish',
            ];
            $loop = get_posts($args);
          @endphp
          @if($loop)
            <h3 class="sidebar__title">Другие акции</h3>
            <div class="sidebar__wrap">
              @foreach($loop as $post)
                @php
                  setup_postdata($post);
                  $isImg = get_the_post_thumbnail_url();
                  $style = $isImg ? "background-image: url(' " . $isImg . " ');" : "background-color: " . get_field('bg') . ";"
                @endphp
                <div class="sidebar__item" style="@php echo $style @endphp">
                  @if(get_field('isAction'))
                    <a href="@php echo get_post_type_archive_link('stock') @endphp" class="actions__info">% Акция</a>
                  @endif
                  <span class="sidebar__item-title">{{the_title()}}</span>
                  <span class="sidebar__item-desc">{{the_field('stock_short_desc')}}</span>
                  <a href="{{the_permalink()}}" class="sidebar__item-more">Подробнее</a>
                </div>
              @endforeach
              @php wp_reset_postdata(); @endphp
            </div>
          @endif
        </aside>
      </div>
    </div>
  </div>
  @endwhile
@endsection
