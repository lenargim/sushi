// import external dependencies
import 'jquery';
import 'slick-carousel'
import 'medium-zoom'
import 'jquery-mask-plugin'

// import local dependencies
import Router from './util/Router';
import common from './routes/common';
import home from './routes/home';
import aboutUs from './routes/about';
import checkout from './routes/checkout';
import account from './routes/account';

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
  // Account page
  account,
});

// Load Events
jQuery(document).ready(() => routes.loadEvents());
