<section class="assortiment">
  <div class="container">
    <div class="assortiment__wrap">
      <h2 class="title">Вся кухня</h2>
      <div class="assortiment__list">
        <a class="assortiment__item" href="/shop/sets">
          <div class="assortiment__img img"><img src="@asset('images/sets.png')" alt='Сеты'/></div>
          <span class="assortiment__name">Сеты</span>
        </a>
        <a class="assortiment__item" href="/shop/sushi">
          <div class="assortiment__img img"><img src="@asset('images/sushi.png')" alt='Суши'/></div>
          <span class="assortiment__name">Суши</span>
        </a>
        <a class="assortiment__item" href="/shop/rolls">
          <div class="assortiment__img img"><img src="@asset('images/rolls.png')" alt='Роллы'/></div>
          <span class="assortiment__name">Роллы</span>
        </a>
        <a href="@php echo get_post_type_archive_link('stock') @endphp" class="assortiment__item">
          <div class="assortiment__img img"><img src="@asset('images/actions.png')" alt='Акции'/></div>
          <span class="assortiment__name">Акции</span>
        </a>
        <a href="/shop/extra" class="assortiment__item assortiment__all">
          <div class="assortiment__img img"><img src="@asset('images/extra.png')" alt='Дополнительно'/></div>
          <span class="assortiment__name"><span>Дополнительно</span> @include('icon::slider-arrow', ['class' => 'arrow'])</span>
        </a>
      </div>
    </div>
  </div>
</section>
