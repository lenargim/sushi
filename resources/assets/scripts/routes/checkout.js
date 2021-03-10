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

$('.woocommerce-notices-wrapper, .woocommerce-NoticeGroup').bind('DOMSubtreeModified',function(){
  if ( $(this).children().length > 1 && !$(this).children('.clear') ) {
    $(this).add('active')
  }
});
