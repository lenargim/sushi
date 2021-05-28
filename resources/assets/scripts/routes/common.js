import Cookie from 'js.cookie';

export default {
  init() {
    // JavaScript to be fired on all pages
  },
  finalize() {
  },
};

let arrow = '<svg width="26" height="17" viewBox="0 0 26 17" fill="none" xmlns="http://www.w3.org/2000/svg">\n' +
  '<path d="M0.505522 7.06751V9.93229H19.4808L14.684 14.5787L16.7762 16.6043L25.1429 8.4999L16.7762 0.395508L14.684 2.42108L19.4808 7.06751H0.505522Z" fill="#252525"/>\n' +
  '</svg>\n';
$('.popular__slider').slick({
  slidesToShow: 4,
  slidesToScroll: 1,
  draggable: false,
  infinite: false,
  appendArrows: $('.popular__slider'),
  prevArrow: '<div class="slider__arrow slider__arrow_prev">' + arrow + '</div>',
  nextArrow: '<div class="slider__arrow slider__arrow_next">' + arrow + '</div>',
  responsive: [
    {
      breakpoint: 1366,
      settings: {
        slidesToShow: 3,
      },
    },
    {
      breakpoint: 769,
      settings: {
        slidesToShow: 2,
      },
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
      },
    },
  ],
})

function putQuantityToInput(id) {
  let product = $(`.product[data-id=${id}]`);
  let gallery = $(`.gallery[data-id=${id}]`);
  product.find('.product__quantity').val(product.attr('data-quantity') );
  gallery.attr('data-quantity', product.attr('data-quantity') )
  gallery.find('.product__quantity').val(product.attr('data-quantity') );
}

function disableCartButtons() {
  $('.product__button').attr('disabled', true);
  setTimeout( () => { $('.product__button').attr('disabled', false)}, 2200 );
}

$('.add_to_cart_button').on('click', function() {
  let id = $(this).siblings('.product__amount').attr('data-id')
  let product = $(`.product[data-id=${id}]`);
  let quantity =  product.attr('data-quantity')
  product.attr('data-quantity', ++quantity)
  putQuantityToInput(id);
  disableCartButtons()
})

$('.product__button').on('click', function() {
disableCartButtons()
let id = $(this).parent('.product__amount').attr('data-id');
let product = $(`.product[data-id=${id}]`);
let quantity = product.attr('data-quantity');
if ( $(this).hasClass('plus') ) {
  $(`.xt_woofc-product[data-id=${id}]`).find('.xt_woofc-quantity-col-plus').click()
  product.attr('data-quantity', ++quantity)
  }
  else if ( $(this).hasClass('minus') ) {
    product.attr('data-quantity', --quantity)
    if (quantity == 0) {
      $(`.xt_woofc-product[data-id=${id}]`).find('.xt_woofc-delete-item span').click()
    } else {
      $(`.xt_woofc-product[data-id=${id}]`).find('.xt_woofc-quantity-col-minus').click()
    }
  }
  putQuantityToInput(id);
})

$('.map').on('click', function () {
  $(this).find('iframe').css({pointerEvents: 'unset'})
})

$('.to-top').on('click', function () {
  $('body,html').animate({
    scrollTop: 0,
  }, 700);
  $('.to-top').removeClass('active')
  return false;
});

// Scroll event
$(window).scroll(function() {
  let scrollHeight = $(window).scrollTop();
  let windowHeight = $(window).height();
  scrollHeight > windowHeight ? $('.to-top').addClass('active') : $('.to-top').removeClass('active')

   // sticky menu
    if( scrollHeight > windowHeight/2 ) {
      $('.menu').hasClass('fixed') ? true :  $('.menu').addClass('fixed')
      $('.menu__mobile').removeClass('active')
      $('.header__mobile').removeClass('active')
      $('.menu__mobile-cart-wrap').addClass('active')
      $('.menu__cart-wrap').appendTo('.menu__mobile-cart-wrap')
    } else {
      $('.menu').removeClass('fixed')
      $('.menu__mobile-cart-wrap').removeClass('active')
      cartReplace()
    }
});


// sorting

if ( Cookie.get( 'ordering' ) == null ) {
  Cookie.set('ordering','popularity_desc' );
} else {
  let hash = Cookie.get( 'ordering' );
  let html = $('.select .option[data-hash=' + hash + ']').html()
  $('.select label').html(html)
  $('.select .option').removeClass('active')
  $('.select .option[data-hash=' + hash + ']').addClass('active')
}

function removeParam(key, sourceURL) {
  var splitUrl = sourceURL.split('?'),
    rtn = splitUrl[0],
    param,
    params_arr = [],
    queryString = (sourceURL.indexOf('?') !== -1) ? splitUrl[1] : '';
  if (queryString !== '') {
    params_arr = queryString.split('&');
    for (var i = params_arr.length - 1; i >= 0; i -= 1) {
      param = params_arr[i].split('=')[0];
      if (param === key) {
        params_arr.splice(i, 1);
      }
    }
    rtn = rtn + '?' + params_arr.join('&');
  }
  return rtn;
}

$('.select label').on('click', function() {
  $(this).parent('.select').toggleClass('active');
})

$('.select .option').on('click', function(event) {
  event.preventDefault()
  let html = $(this).html();
  $('.select .option').removeClass('active')
  $(this).addClass('active');
  let hash = $(this).attr('data-hash')
  Cookie.set('ordering',hash,{ path:'/'} );
  $('.select label').html( html )
  let url = $(location).attr('href');
  hash = `orderby=${hash}`;
  let cleanUrl = removeParam('orderby',url)
  //url = url.split('?')[0]; // очистить get запрос
  //$(location).attr('href', `${url}?orderby=${hash}`);
  $(location).attr('href', cleanUrl+'?'+hash);
})


$('main.main').mouseup(function (e) { // событие клика по веб-документу
  let div = $('.select'); // тут указываем элемент
  if (!div.is(e.target) // если клик был не по нашему блоку
    && div.has(e.target).length === 0) { // и не по его дочерним элементам
    $('div.select').removeClass('active')
  }
});


// sale and spicy filters
if ( Cookie.get( 'on_sale' ) == '1' ) {
  $('#sale-filter').prop('checked', true)
} else {
  $('#sale-filter').prop('checked', false)
}

if ( Cookie.get( 'is_spicy' ) == '1' ) {
  $('#spicy-filter').prop('checked', true)
} else {
  $('#spicy-filter').prop('checked', false)
}


$('#sale-filter').change( function(){
  if ( $(this).is(':checked') ) {
     Cookie.set('on_sale','1' );
  } else {
  Cookie.set('on_sale','0' );
  }
location.reload();
});

$('#spicy-filter').change( function(){
  if ( $(this).is(':checked') ) {
     Cookie.set('is_spicy','1' );
  } else {
  Cookie.set('is_spicy','0' );
  }
location.reload();
});

$('.product__img, .product-thumbnail').on('click', function(){
  let gallery = $(this).siblings('.gallery');
  gallery.addClass('active');
  let overlay = $('.overlay')
  overlay.html(gallery)
  overlay.addClass('active')
  gallery.find('.gallery__images').slick({
    'slidesToShow': 1,
    'slidesToScroll': 1,
    'arrows': false,
    'dots': true,
    'draggable': false,
  })
})

$('.overlay').mouseup(function (e) { // событие клика по веб-документу
  let modal = $('.modal.active'); // тут указываем элемент
  if( modal.hasClass('thankyou') ) {
         window.location = '/';
      }
  let id = modal.attr('data-id')
  if (!modal.is(e.target) // если клик был не по нашему блоку
    && modal.has(e.target).length === 0) { // и не по его дочерним элементам
    modal.find('.gallery__images').slick('unslick')
    modal.removeClass('active')
    modal.prependTo(`.product.post-${id}`);
    modal.prependTo(`.woocommerce-cart-form__cart-item[data-id=${id}]`);
    $('.overlay').removeClass('active')
    $('.overlay').html('')
  }
});

$('.header__search-svg').on('click', function(){
  let parent = $(this).parents('.header__account-block')
  parent.children('.icon').hide()
  parent.siblings('.header__socials').hide()
  parent.find('.header__phone-mobile').hide()
  parent.find('.menu__cart-wrap').hide()
  let wrapper = parent.children('.header__search')
  wrapper.addClass('active')
  wrapper.find('input[type=search]').focus()
})

$('.header__search-close').on('click', function(){
  let parent = $(this).parents('.header__account-block')
  if ($(window).width() > 1023 ) {
    parent.children('.icon').show()
    parent.siblings('.header__socials').show()
  } else {
    parent.find('.header__phone-mobile').show()
    parent.find('.menu__cart-wrap').show()
  }
  parent.children('.header__search').removeClass('active')
})

$('.product a:contains("Острое")').addClass('product__tag spicy');
$('.product a:contains("Акция")').addClass('product__tag stock');
$('.product a:contains("Запеченный")').addClass('product__tag baked');
$('.product a:contains("Горячее")').addClass('product__tag hot');
$('.product a:contains("New")').addClass('product__tag new');
$('.product a:contains("СУПЕР ЦЕНА")').addClass('product__tag super');
$('.product a:contains("Premium")').addClass('product__tag premium');
$('.product__tag').on('click', function(e){
  e.preventDefault()
} )

$('.close').on('click', function(){
  $(this).parent().hide()
  $(this).parent().removeClass('active')
  $('.overlay').removeClass('active')

  if( $(this).parent().hasClass('thankyou') ) {
     window.location = '/';
  }

  if( $(this).parent().hasClass('gallery') ) {
    let modal = $('.modal.active');
    let id = modal.attr('data-id');
    modal.find('.gallery__images').slick('unslick')
    modal.removeClass('active');
    modal.prependTo(`.product.post-${id}`);
    $('.overlay').removeClass('active');
    $('.overlay').html('');
    }
})

$('.header__mobile').on('click', function(){
  if ( $(this).hasClass('active') ) {
    $(this).removeClass('active')
    $('.menu__mobile').removeClass('active')
  } else {
    $(this).addClass('active')
    $('.menu__mobile').addClass('active')
  }
})

function cartReplace() {
  if( $(window).width() < 1023) {
    $('.menu__cart-wrap').appendTo('.header__account-block')
  } else {
    $('.menu__cart-wrap').appendTo('.menu__wrap')
  }
}

$( window ).resize(function() {
 cartReplace()
});

$('a[href^="#"]').click(function(event){
  let shift;
  let width = $(window).width()
  width > 1799 ? shift = 150 : shift = 100
  $('.menu__sub-item').removeClass('active')
  $(this).addClass('active')
  event.preventDefault()
  let anchor = $(this).attr('href');
  $('html, body').animate({
  scrollTop: $(anchor).offset().top - shift,
  }, 800);
});


$(window).on('scroll resize',function() {
  $('a.menu__sub-item').removeClass('active');
  let $sections = $('.category-page__block');
  $sections.each(function(i,el){
    let top  = $(el).offset().top-250;
    let bottom = top +$(el).height();
    let scroll = $(window).scrollTop();
    let id = $(el).prev().attr('id');
    if( scroll > top && scroll < bottom){
    $('a[href="#'+id+'"]').addClass('active');
    }
  });
});

$('input[type="tel"]').mask('+7(Z00) 000-00-00', { translation: { 'Z': { pattern: /[0-79]/ } } })
$('.product__img img').css('aspect-ratio', '938 / 623')
$('.drop-filters').on('click', function(){
  Cookie.set('on_sale','0' );
  Cookie.set('is_spicy','0' );
   location.reload();
})
