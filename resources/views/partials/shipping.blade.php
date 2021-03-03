<section class="shipping">
  <div class="container">
    <h2 class="title">Бесплатная доставка и подарки</h2>
    <div class="description">Закажите на сумму выше определенного порога, и получите скидку, а также подарок!</div>
    <div class="shipping__wrap">
      <div class="shipping__item">
        @include('icon::delivery', ['class' => 'shipping__logo'])
        <div class="shipping__price">от 1 000 рублей</div>
        <div class="shipping__info">Бесплатная<br> доставка!</div>
      </div>
      <div class="shipping__item">
        @include('icon::sushi', ['class' => 'shipping__logo'])
        <div class="shipping__price">от 2 000 рублей</div>
        <div class="shipping__info">Роллы “Калифорния”<br> в подарок.</div>
      </div>
      <div class="shipping__item">
        <img class="shipping__logo" src="@asset('images/sushibottle.png')" alt="">
        <div class="shipping__price">от 5 000 рублей</div>
        <div class="shipping__info">Бесплатный набор роллов<br> “Калифорния” + Напиток<br> Coca-Cola 1л.</div>
      </div>
    </div>
  </div>
</section>
