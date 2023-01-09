/******/ (function() { // webpackBootstrap
var __webpack_exports__ = {};
/*!*******************************************!*\
  !*** ./resources/js/pages/rating-init.js ***!
  \*******************************************/
/*
Project Name: MNB - Admin & Dashboard
Author: Nabeel Baig
Version: 4.0.0.
Website: https://technosavvyllc.com
Contact: info@technosavvyllc.com
File: Rating Js File
*/

$(function () {
  $('input.check').on('change', function () {
    alert('Rating: ' + $(this).val());
  });
  $('.rating-tooltip').rating({
    extendSymbol: function extendSymbol(rate) {
      $(this).tooltip({
        container: 'body',
        placement: 'bottom',
        title: 'Rate ' + rate
      });
    }
  });
  $('.rating-tooltip-manual').rating({
    extendSymbol: function extendSymbol() {
      var _title;
      $(this).tooltip({
        container: 'body',
        placement: 'bottom',
        trigger: 'manual',
        title: function title() {
          return _title;
        }
      });
      $(this).on('rating.rateenter', function (e, rate) {
        _title = rate;
        $(this).tooltip('show');
      }).on('rating.rateleave', function () {
        $(this).tooltip('hide');
      });
    }
  });
  $('.rating').each(function () {
    $('<span class="badge bg-info"></span>').text($(this).val() || '').insertAfter(this);
  });
  $('.rating').on('change', function () {
    $(this).next('.badge').text($(this).val());
  });
});
/******/ })()
;