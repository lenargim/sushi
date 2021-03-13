export default {
  init() {
    // JavaScript to be fired on the home page
  },
  finalize() {
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
  },
};
