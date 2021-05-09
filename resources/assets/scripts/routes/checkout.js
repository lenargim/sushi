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

const token = '7ddfb736edd271b94a75fafbcb6844e6bdc77121';


jQuery('#billing_first_name').suggestions({
  token: token,
  type: 'NAME',
});

jQuery('#billing_first_name').attr('autocomplete', 'name');
jQuery('#billing_address_1').val('');

$('.order__promo-more').on('click', function () {
  $(this).siblings('.order__promo-addition').toggleClass('active');
});

$('.order__promo-button').on('click', function () {
  let msg = $(this).data('msg');
  $('#shisha').val(msg);
  $('.overlay').removeClass('active');
  $('.order__promo').removeClass('active');
});
