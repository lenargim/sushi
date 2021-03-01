export default {
  init() {
    // JavaScript to be fired on all pages
  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
  },
};

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

$('.add_to_cart_button').on('click', function() {
  let quantity =  $(this).parents('.product__function').find('.product__quantity').val()
  $(this).parents('.product__function').find('.product__quantity').val(++quantity);
  $(this).parents('.product__function').attr('data-amount', ++quantity)
})

