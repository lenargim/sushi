@php $isImg = get_the_post_thumbnail_url() @endphp
@php $style = $isImg ? "background-image: url(' " . $isImg . " ');" : "background-color: " . get_field('bg') . ";"  @endphp
<div class="actions__item" style="@php echo $style @endphp">
  @if(get_field('isAction'))
    <a href="@php echo get_post_type_archive_link('stock') @endphp" class="actions__info">% Акция</a>
  @endif
  <span class="actions__title">{{the_title()}}</span>
  <span class="actions__desc">{{the_field('stock_short_desc')}}</span>
  <a href="{{the_permalink()}}" class="actions__more">Подробнее</a>
</div>
