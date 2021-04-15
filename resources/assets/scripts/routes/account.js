export default {
  init() {
    // JavaScript to be fired on all pages
  },
  finalize() {
  },
};

$('.account__dashboard-button').on('click', function () {
  $('.account__dashboard').hide();
  $('.account__dashboard-edit').addClass('active')
});
