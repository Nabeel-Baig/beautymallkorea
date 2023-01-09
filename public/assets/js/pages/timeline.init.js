/******/ (function() { // webpackBootstrap
var __webpack_exports__ = {};
/*!*********************************************!*\
  !*** ./resources/js/pages/timeline.init.js ***!
  \*********************************************/
/*
Project Name: MNB - Admin & Dashboard
Author: Nabeel Baig
Version: 4.0.0.
Website: https://technosavvyllc.com
Contact: info@technosavvyllc.com
File: Timeline Init Js File
*/

$('#timeline-carousel').owlCarousel({
  items: 1,
  loop: false,
  margin: 0,
  nav: true,
  navText: ["<i class='mdi mdi-chevron-left'></i>", "<i class='mdi mdi-chevron-right'></i>"],
  dots: false,
  responsive: {
    576: {
      items: 2
    },
    768: {
      items: 4
    }
  }
});
/******/ })()
;