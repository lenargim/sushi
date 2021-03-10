<section class="assortiment">
  <div class="container">
    <div class="assortiment__wrap">
      <h2 class="title">Вся кухня</h2>
      <div class="assortiment__list">
        <a class="assortiment__item" href="/shop/sets">
          <img src="@asset('images/set-a.jpg')" alt='Сеты'/>
          <span class="assortiment__name">Сеты</span>
        </a>
        <a class="assortiment__item" href="/shop/sushi">
          <img src="@asset('images/sushi.png')" alt='Суши'/>
          <span class="assortiment__name">Суши</span>
        </a>
        <a class="assortiment__item" href="/shop/rolls">
          <img src="@asset('images/roll-a.jpg')" alt='Роллы'/>
          <span class="assortiment__name">Роллы</span>
        </a>
        <a href="@php echo get_post_type_archive_link('stock') @endphp" class="assortiment__item">
          <img src="@asset('images/actions.jpg')" alt='Акции'/>
          <span class="assortiment__name">Акции</span>
        </a>
        <a href="/shop" class="assortiment__item" style="background-color: #1D1D17;">
          <span class="assortiment__name">Все категории @include('icon::slider-arrow', ['class' => 'arrow'])</span>
        </a>
      </div>
    </div>
  </div>
</section>

