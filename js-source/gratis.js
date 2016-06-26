/**
 * @file
 * Misc js for gratis 2.
 */

(function ($, Drupal) {

  Drupal.behaviors.gratisMiscfunctions = {
    attach: function (context) {

      // Scroll to top.
      $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
          $('.scrolltop').fadeIn();
        } else {
          $('.scrolltop').fadeOut();
        }
      });

      $('.scrolltop').click(function () {
        $("html, body").animate({scrollTop: 0}, 500);
        return false;
      });

      // End scroll to top.
    }
  };

  /**
   * Toggle expanded menu states.
   */
  Drupal.behaviors.gratisExpandMenus = {
    attach: function (context) {

      // Off-canvas, check for child elements on parent menu.
      $('.main-menu-wrapper ul li').each(function () {
        if ($('ul', this).length) {
          $(this).addClass('has-child');
        }
      });

      // Nested off canvas menu items.
      $('.menu .has-child').not('.active-trail').removeClass('has-child');
      $('.menu li a').each(function () {
        if ($(this).parent().children('ul').length !== 0 && $(this).parent().children(".nested-menu-item-toggle").length == 0) {
          $(this).after('<a href="#" class="nested-menu-item-toggle"></a>');
        }
      });
      $('.nested-menu-item-toggle').click(function () {
        $(this).closest('li').toggleClass('has-child');
        return false;
      });

    }
  };

})(jQuery, Drupal);
