<section class="assortiment">
  <div class="container">
    <div class="assortiment__wrap">
      <h2 class="title">Наш ассортимент</h2>
      <div class="assortiment__list">
        @php
          $args = [
            'taxonomy' => 'product_cat',
            'number' => 3,
            'hide_empty' => true,
            'parent'      => 0,
            'orderby' => 'description',
            'order' => 'ASC'

          ];
          $assortiment = get_categories($args);
        @endphp
        @foreach ($assortiment as $category)
          <a class="assortiment__item" href="@php echo get_category_link($category->term_id) @endphp">
            @php
              $thumbnail_id = get_term_meta( $category->term_id, 'thumbnail_id', true );
              $image = wp_get_attachment_url( $thumbnail_id );
            echo "<img src='{$image}' alt='assortiment' />"
            @endphp
            <span class="assortiment__name">@php echo $category->name @endphp</span>
          </a>
        @endforeach
        <a href="@php echo get_post_type_archive_link('stock') @endphp" class="assortiment__item">
          <img src="@asset('images/actions.jpg')" alt='assortiment'/>
          <span class="assortiment__name">Акции</span>
        </a>
        <a href="/category" class="assortiment__item">
          <img src="@asset('images/actions.jpg')" alt='assortiment'/>
          <span class="assortiment__name">Все категории @include('icon::slider-arrow', ['class' => 'arrow'])</span>
        </a>
      </div>
    </div>
  </div>
</section>

