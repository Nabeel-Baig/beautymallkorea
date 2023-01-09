/******/ (function() { // webpackBootstrap
var __webpack_exports__ = {};
/*!************************************************!*\
  !*** ./resources/js/pages/coming-soon.init.js ***!
  \************************************************/
/*
Project Name: MNB - Admin & Dashboard
Author: Nabeel Baig
Version: 4.0.0.
Website: https://technosavvyllc.com
Contact: info@technosavvyllc.com
File: coming soon Init Js File
*/

$('[data-countdown]').each(function () {
  var $this = $(this),
    finalDate = $(this).data('countdown');
  $this.countdown(finalDate, function (event) {
    $(this).html(event.strftime('' + '<div class="coming-box">%D <span>Days</span></div> ' + '<div class="coming-box">%H <span>Hours</span></div> ' + '<div class="coming-box">%M <span>Minutes</span></div> ' + '<div class="coming-box">%S <span>Seconds</span></div> '));
  });
});
/******/ })()
;