/**
* @file
* Misc JQuery scripts in this file
*/

(function ($) {

// Add drupal 7 code.
Drupal.behaviors.miscGratis = {
  attach:function (context, settings) {
// End drupal calls.

$('body').addClass('js');

/* 
* Toggle the main menu, it's hidden initially
* to prevent FOUC. 
*/
//$("#main-menu ul.flexnav").show();

// Set ul depths for better theming.
$('#main-menu ul').each(function() {
  var depth = $(this).parents('ul').length;
  $(this).addClass('ul-depth-' + depth);
});

// Set ul > li depths for better theming.
$('#main-menu ul li').each(function() {
  var depth = $(this).parents('li').length;
  $(this).addClass('li-depth-' + depth);
});

// Set li > a depths for better theming.
$('#main-menu ul li a').each(function() {
  var depth = $(this).parents('ul').length;
  $(this).addClass('ula-depth-' + depth);
});

$('#main-menu li.expanded.level-1 a.ula-depth-1').append('<i class="icon-fixed-width desktop-nav">&#xf13a;</i>');
$('#main-menu li.expanded.level-1').append('<i class="icon-fixed-width mobile-nav">&#xf13a;</i>');
$('#main-menu li.expanded.level-1 a.ula-depth-2').prepend('<i class="icon-fixed-width sub-menu-item">&#xf138;</i>');

  $('#main-menu li.level-1 li:visible:first-child').addClass('first');
  $('#main-menu li.level-1 li:visible:last-child').addClass('last');

// Mobile menu
var $menu = $('#menu'),
$menulink = $('.menu-link'),
$menuTrigger = $('.expanded > .icon-fixed-width.mobile-nav');

$menulink.click(function(e) {
  e.preventDefault();
  $menulink.toggleClass('active');
  $menu.toggleClass('active');
});

$menuTrigger.click(function(){
  $(this).closest('li').find('ul.menu.ul-depth-1').toggleClass('active');
});

// Prepend the post date before the h1.
$(".date-in-parts")
.prependTo(".not-front.page-node #post-content");

// Global zebra stripes and first / last.
$("article:visible:even").addClass("even");
$("article:visible:odd").addClass("odd");
$("#post-content article:last").addClass("last");
$("#post-content article:first").addClass("first");

// Add a wrapper around the image field.
$('.field-type-image li').each(function () {
  $(this).wrapInner('<span class="image-block">');
});

// Add comment icons using font awesome.
$('.comment-add').prepend('<i class="icon-fixed-width">&#xf040;</i>');
$('.comment-comments').prepend('<i class="icon-fixed-width">&#xf02d;</i>');
$('.node-readmore').prepend('<i class="icon-fixed-width">&#xf0a9;</i>');



$('.is-node article .field-name-body ul, .field-type-text-with-summary ul, .field-type-text ul, .sidebar .block-content ul').addClass('icons-ul');
$('.is-node article .field-name-body ul li, .field-type-text-with-summary ul li, .field-type-text ul li, .sidebar .block-content ul li').prepend('<i class="icon-li icon-chevron-right"></i>');

// Blockquote.
$('blockquote').prepend('<i class="icon-quote-left icon-4x pull-left icon-muted"></i>');

// Node block - this should come last. It gets appened to the body field if it exists.
if ( $(".field").hasClass("field-name-body")) {
  $(".region-node-block")
  .appendTo(".field-name-body");
}

}}}) (jQuery);
