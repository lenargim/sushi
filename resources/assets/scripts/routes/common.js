export default {
  init() {
    // JavaScript to be fired on all pages
  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
  },
};

$('.product__button').on('click', function() {
const quantity = +$(this).siblings('.product__quantity').val();
const id = $(this).parent('.product__amount').data('id');
if ( $(this).hasClass('plus') ) {
  $(`.xt_woofc-product[data-id=${id}]`).find('.xt_woofc-quantity-col-plus').click()
  }
else if ( $(this).hasClass('minus') && quantity > 2 ) {
  $(`.xt_woofc-product[data-id=${id}]`).find('.xt_woofc-quantity-col-minus').click()
  }
else {
  $(`.xt_woofc-product[data-id=${id}]`).find('.xt_woofc-delete-item span').click()
  }
})
