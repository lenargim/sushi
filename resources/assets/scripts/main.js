// import external dependencies
import 'jquery';
import 'slick-carousel'
import 'medium-zoom'

// import local dependencies
import Router from './util/Router';
import common from './routes/common';
import home from './routes/home';
import aboutUs from './routes/about';
import checkout from './routes/checkout';

/** Populate Router instance with DOM routes */
const routes = new Router({
  // All pages
  common,
  // Home page
  home,
  // About Us page, note the change from about-us to aboutUs.
  aboutUs,
  // Checkout page
  checkout,
});

// Load Events
jQuery(document).ready(() => routes.loadEvents());
