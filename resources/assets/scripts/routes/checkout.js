export default {
  init() {
    // JavaScript to be fired on all pages
  },
  finalize() {
  },
};

$('body').on('blur change', '#billing_first_name', function(){
  var wrapper = $(this).closest('.form-row');
  // you do not have to removeClass() because Woo do it in checkout.js
  if( /\d/.test( $(this).val() ) ) { // check if contains numbers
    wrapper.addClass('woocommerce-invalid'); // error
  } else {
    wrapper.addClass('woocommerce-validated'); // success
  }
});

//
// $('body').on('change', '#billing_address_1', function(){
//   let address = $('#billing_address_1').val();
//   if (address.length > 1) {
//     let yandexAddress = $('input.ymaps-2-1-78-searchbox-input__input');
//     $('html, body').animate({
//       scrollTop: yandexAddress.offset().top,
//     }, 1000);
//     yandexAddress.val(address);
//   }
// });

let token = '7ddfb736edd271b94a75fafbcb6844e6bdc77121';
$('#billing_address_1').suggestions({
  token: token,
  type: 'ADDRESS',
  constraints: {
    locations: { city: 'Самара' },
  },
  /* Вызывается, когда пользователь выбирает одну из подсказок */
  onSelect: function(suggestion) {
    //let coordinates = suggestion.data.geo_lat + ', ' + suggestion.data.geo_lon;
    let yandexAddress = $('input.ymaps-2-1-78-searchbox-input__input');
    yandexAddress.val(suggestion.value);
    $('.ymaps-2-1-78-searchbox-button').click();
    $('body').trigger('update_checkout');
  },
});

$('#billing_first_name').suggestions({
  token: token,
  type: 'NAME',
});

$('#billing_first_name').attr('autocomplete', 'name');
$('#billing_address_1').val('');
