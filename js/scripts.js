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

// Start flexnav. 
$(".flexnav").flexNav();

      // End mobile menu.

// prepend the post date before the h1.
  $(".date-in-parts")
    .prependTo(".not-front.page-node #post-content");

// Global zebra stripes and first / last.
  $("article:visible:even").addClass("even");
  $("article:visible:odd").addClass("odd");
  $("#post-content article:last").addClass("last");
  $("#post-content article:first").addClass("first");


// Set image captions for the image field.
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

// Add a wrapper around the image field. 
  $('.field-type-image li') .each(function () {
    $(this).wrapInner('<span class="image-block">');
  });

  // Make nav arrow and link uniform classes.
$('#main-menu li.level-1').on('mouseover', function() {
    var li$ = $(this);
    li$.parent('ul').find('li').removeClass('hover-state');
    li$.addClass('hover-state');
})

.on('mouseout', function() {
    var li$ = $(this);
    li$.removeClass('hover-state');
    li$.parent('ul').find('li.current').addClass('hover-state');
});

// Add comment icons using font awesome.
$('.comment-add').prepend('<i class="icon-fixed-width">&#xf040;</i>');
$('.comment-comments').prepend('<i class="icon-fixed-width">&#xf02d;</i>');
$('.node-readmore').prepend('<i class="icon-fixed-width">&#xf0a9;</i>');
$('.is-node article .field-name-body ul li, .field-type-text-with-summary ul li, .field-type-text ul li').prepend('<i class="icon-fixed-width">&#xf054;</i>');



  }}})
(jQuery);
