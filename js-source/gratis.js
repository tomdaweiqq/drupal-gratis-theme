/**
 * @file
 * Misc js for gratis, Drupal 8.x-3.x.
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
  Drupal.behaviors.gratisDesktopMenu = {
    attach: function (context) {

      // Desktop menu, define variables.
      var nav_level_one = $('#block-gratis-main-menu ul.menu-level--1 > li');
      var nav_level_two = $('#block-gratis-main-menu ul.menu-level--2 > li');

      // Desktop menu, add classes for active trail and hover states.
      nav_level_one.hover(
        function () {
          $(this).addClass('active-menu-trail').removeClass('inactive-menu-trail');
          $(this).children('ul.menu-level--2').addClass('hover').removeClass('hover-off');
        },
        function () {
          $(this).addClass('inactive-menu-trail').removeClass('active-menu-trail');
          $(this).children('ul.menu-level--2').removeClass('hover').addClass('hover-off');
        }
      );

      nav_level_two.hover(
        function () {
          $(this).addClass('active-menu-trail').removeClass('inactive-menu-trail');
          $(this).children('ul.menu-level--3').addClass('hover').removeClass('hover-off');
        },
        function () {
          $(this).addClass('inactive-menu-trail').removeClass('active-menu-trail');
          $(this).children('ul.menu-level--3').removeClass('hover').addClass('hover-off');
        }
      );

      // Check for main menu child elements.
      $(nav_level_one).each(function () {
        if ($('> ul', this).length) {
          $(this).addClass('has-child-secondary');
        }
      });

      $(nav_level_two).each(function () {
        if ($('> ul', this).length) {
          $(this).addClass('has-child-tertiary');
        }
      });

    }
  };

})(jQuery, Drupal);
