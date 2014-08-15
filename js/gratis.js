/**
 * @file
 * Misc js for gratis 2.
 */

(function ($, Drupal) {

  Drupal.behaviors.gratisMiscfunctions = {
    attach: function (context) {

      // Check for child elements on parent menu.
      $('.main-menu-wrapper ul li').each(function(){
        if($('ul',this).length){
          $(this).addClass('has-child');
        }
      });

    }
  };

  /**
   * Toggle show/hide links for off canvas layout.
   *
   */
  Drupal.behaviors.gratisOffCanvasLayout = {
    attach: function (context) {

      $('.l-page').click(function (e) {
        var offCanvasVisible = $('.l-page-wrapper').hasClass('off-canvas-left-is-visible') || $('.l-page-wrapper').hasClass('off-canvas-right-is-visible');
        var targetIsOfOffCanvas = $(e.target).closest('.l-off-canvas').length !== 0;
        if (offCanvasVisible && !targetIsOfOffCanvas) {
          $('.l-page-wrapper').removeClass('off-canvas-left-is-visible off-canvas-right-is-visible');
          e.preventDefault();
        }
      });

      $('.l-off-canvas-show--left').click(function (e) {
        $('.l-page-wrapper').removeClass('off-canvas-left-is-visible off-canvas-right-is-visible');
        $('.l-page-wrapper').addClass('off-canvas-left-is-visible');
        e.stopPropagation();
        e.preventDefault();
      });

      $('.l-off-canvas-show--right').click(function (e) {
        $('.l-page-wrapper').removeClass('off-canvas-left-is-visible off-canvas-right-is-visible');
        $('.l-page-wrapper').addClass('off-canvas-right-is-visible');
        e.stopPropagation();
        e.preventDefault();
      });

      $('.l-off-canvas-hide').click(function (e) {
        $('.l-page-wrapper').removeClass('off-canvas-left-is-visible off-canvas-right-is-visible');
        e.stopPropagation();
        e.preventDefault();
      });

    }
  };

  /**
   * Toggle expanded menu states.
   */
  Drupal.behaviors.gratisExpandMenus = {
    attach: function (context) {

// Nested off canvas menu items.
      $('.menu .expanded').not('.active-trail').removeClass('expanded');
      $('.menu li a').each(function () {
        if ($(this).parent().children('ul').length !== 0) {
          $(this).after('<a href="#" class="nested-menu-item-toggle"></a>');
        }
      });
      $('.nested-menu-item-toggle').click(function () {
        $(this).closest('li').toggleClass('expanded');
        return false;
      });
    }
  };

})(jQuery, Drupal);
