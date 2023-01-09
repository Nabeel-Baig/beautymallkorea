/******/ (function() { // webpackBootstrap
var __webpack_exports__ = {};
/*!*********************************************************!*\
  !*** ./resources/js/pages/product-filter-range.init.js ***!
  \*********************************************************/
/*
Project Name: MNB - Admin & Dashboard
Author: Nabeel Baig
Version: 4.0.0.
Website: https://technosavvyllc.com
Contact: info@technosavvyllc.com
File: Property list filter init js
*/

$(document).ready(function () {
  $("#pricerange").ionRangeSlider({
    skin: "square",
    type: "double",
    grid: true,
    min: 0,
    max: 1000,
    from: 200,
    to: 800,
    prefix: "$"
  });
});
/******/ })()
;