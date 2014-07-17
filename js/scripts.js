/**
 * Toggle show/hide links for off canvas layout.
 *
 * Misc functions for Gratis
 */

(function ($, Drupal) {

  Drupal.behaviors.gratisMiscfunctions= {
    attach: function (context) {

      // functions

    }
  };

  /**
   * Toggle show/hide links for off canvas layout.
   *
   */
  Drupal.behaviors.gratisOffCanvasLayout = {
    attach: function (context) {


      $('.l-page').click(function(e) {
        var offCanvasVisible = $('.l-page-wrapper').hasClass('off-canvas-left-is-visible') || $('.l-page-wrapper').hasClass('off-canvas-right-is-visible');
        var targetIsOfOffCanvas = $(e.target).closest('.l-off-canvas').length !== 0;
        if (offCanvasVisible && !targetIsOfOffCanvas) {
          $('.l-page-wrapper').removeClass('off-canvas-left-is-visible off-canvas-right-is-visible');
          e.preventDefault();
        }
      });

      $('.l-off-canvas-show--left').click(function(e) {
        $('.l-page-wrapper').removeClass('off-canvas-left-is-visible off-canvas-right-is-visible');
        $('.l-page-wrapper').addClass('off-canvas-left-is-visible');
        e.stopPropagation();
        e.preventDefault();
      });

      //

      $('.l-off-canvas-show--right').click(function(e) {
        $('.l-page-wrapper').removeClass('off-canvas-left-is-visible off-canvas-right-is-visible');
        $('.l-page-wrapper').addClass('off-canvas-right-is-visible');
        e.stopPropagation();
        e.preventDefault();
      });

      $('.l-off-canvas-hide').click(function(e) {
        $('.l-page-wrapper').removeClass('off-canvas-left-is-visible off-canvas-right-is-visible');
        e.stopPropagation();
        e.preventDefault();
      });

    }
  };

})(jQuery, Drupal);
