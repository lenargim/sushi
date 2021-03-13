import Cookie from 'js.cookie';
export default {
  init() {
    // JavaScript to be fired on all pages
  },
  finalize() {
  },
};

$('.add_to_cart_button').on('click', function() {
  let quantity =  $(this).parents('.product__function').find('.product__quantity').val()
  $(this).parents('.product__function').find('.product__quantity').val(++quantity);
  $(this).parents('.product__function').attr('data-amount', ++quantity)
})

$('.product__button').on('click', function() {
$(this).attr('disabled', true);
setTimeout( () => { $(this).attr('disabled', false)}, 1000 );
let quantity = $(this).siblings('.product__quantity').val();
const id = $(this).parent('.product__amount').data('id');
$(this).parents('.product__function').attr('data-amount', +quantity);
if ( $(this).hasClass('plus') ) {
  $(`.xt_woofc-product[data-id=${id}]`).find('.xt_woofc-quantity-col-plus').click()
  $(this).siblings('.product__quantity').val(++quantity)
  }
else if ( $(this).hasClass('minus') && quantity  >= 2 ) {
  $(`.xt_woofc-product[data-id=${id}]`).find('.xt_woofc-quantity-col-minus').click()
  $(this).siblings('.product__quantity').val(--quantity)
  }
else if ( $(this).hasClass('minus') && quantity == 1 ) {
  $(`.xt_woofc-product[data-id=${id}]`).find('.xt_woofc-delete-item span').click()
  $(this).siblings('.product__quantity').val(--quantity)
  }
  $(this).parents('.product__function').attr('data-amount', +quantity)
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
  let docHeight = $(document).height();

  // to top
  if( scrollHeight + windowHeight >= docHeight && windowHeight*2 < docHeight ) {
      $('.to-top').addClass('active')
   } else if ( scrollHeight < windowHeight/2 ) {
      $('.to-top').removeClass('active')
   }

   // sticky menu
    if( scrollHeight > windowHeight/2 ) {
      $('.menu').hasClass('fixed') ? true :  $('.menu').addClass('fixed')
      $('.menu__mobile').removeClass('active')
      $('.header__mobile').removeClass('active')
      $('.menu__mobile').html('')
    } else {
      $('.menu').removeClass('fixed')
    }
});


// sorting
if ( Cookie.get( 'ordering' ) == '' ) {
  Cookie.set('ordering','popularity_asc' );
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

$('.product__img').on('click', function(){
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
    $('.overlay').removeClass('active')
    $('.overlay').html('')
  }
});

$('.header__search-svg').on('click', function(){
  let parent = $(this).parents('.header__account-block')
  parent.children('.icon').hide()
  parent.siblings('.header__socials').hide()
  parent.children('.header__search').addClass('active')
})

$('.header__search-close').on('click', function(){
  let parent = $(this).parents('.header__account-block')
  parent.children('.icon').show()
  parent.siblings('.header__socials').show()
  parent.children('.header__search').removeClass('active')
})

$('.product a:contains("Острое")').addClass('spicy')
$('.product a:contains("Акция")').addClass('stock')
$('.product a:contains("Запеченный")').addClass('baked')

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
    $('.menu__mobile').html('')
    $('.menu__mobile').removeClass('active')
  } else {
  $(this).addClass('active')
  $('.menu__mobile').addClass('active')
    $('.nav-primary').clone().appendTo('.menu__mobile').show()
    $('.header__search-form').clone().appendTo('.menu__mobile').show()
    $('.header__socials').clone().appendTo('.menu__mobile').show()
    $('.header__info').clone().appendTo('.menu__mobile').show()
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
