/**
 * @file
 * Misc JQuery scripts in this file
 */

(function ($) {

// Add drupal 7 code.
  Drupal.behaviors.miscBamboo = {
    attach:function (context, settings) {
// End drupal calls.

      $('html').addClass('js');

// Set Ul depths for better theming.
$('#main-menu ul').each(function() {
  var depth = $(this).parents('ul').length;
  $(this).addClass('ul-depth-' + depth);
});

// Set li depths for better theming.
$('#main-menu ul li').each(function() {
  var depth = $(this).parents('li').length;
  $(this).addClass('li-depth-' + depth);
});

$('#main-menu ul li a').each(function() {
        var depth = $(this).parents('ul').length;
        $(this).addClass('ula-depth-' + depth);
      });

// Start flexnav. 
$(".flexnav").flexNav();

      // End mobile menu.

// prepend the post date before the h1.
  $(".date-in-parts")
    .prependTo(".not-front.page-node #post-content");

// Global zebra stripes and first / last.
  $(".front article:visible:even").addClass("even");
  $(".front article:visible:odd").addClass("odd");
  $(".front #post-content article:last").addClass("last");
  $(".front #post-content article:first").addClass("first");


// Set image captions for image field.
  $(".field-type-image img").each(function (i, ele) {
    var alt = this.alt;
      if ($("img-caption").length == 0) {
        $(this).closest(".field-type-image .field-item").append("<span " +
          "class='img-caption'>" + this.alt + "</span>");
        }
        else {
          $(this).closest(".field-type-image .field-item").append("");
        }
  });

  $('.field-type-image li') .each(function () {
    $(this).wrapInner('<span class="image-block">');
  });

  }}})
(jQuery);
