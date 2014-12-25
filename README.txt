Version 2.0, December, 2014

-- SUMMARY --

Gratis 2 is a responsive Drupal 7 HTML5 theme designed and developed by
Danny Englander (Twitter: @Danny_Englander). Gratis 2.0 has been re-architected
from the ground up using LibSass, Neat, Boubon, and Grunt.

Gratis allows for a choice color palettes in the theme's settings page. and is
aimed at users who want to get a nice looking theme up and
running in short order, may not want to take the time to create a sub-theme
and fiddle with regions, settings, media queries, and other highly technical
things. It's also aimed at a casual Drupal user who has some familiarity
with building sites. This theme also does not require any base theme.

-- Gratis, LibSass, and Grunt
Gratis 2 now uses Grunt and LibSass via Node.js NPM (Grunt Sass)
To get up and running, follow the steps below:

1. Install node.js from http://nodejs.org/
2. cd to the gratis folder (or your subtheme)
3. run sudo npm install (if all went well, you will now have your local node modules)
4. run grunt
5. make css changes

-- CONFIGURATION --

- Configure theme settings in Administration > Appearance > Settings >
gratis or admin/appearance/settings/gratis and choose various options
available.

-- THEME SETTINGS UI --

- Choice of several color palettes: Turquoise Blue, Cool Purple, Pumpkin
Orange, Olive Green, Pomegranate Red, Seafoam Green, Green Gray.  
gratis 2 also has some new colors, Mustard and Royal Turquoise.

- Toggle Breadcrumbs on or off

- Local CSS - Choose to enable local.css file within the theme folder.

- Custom Path CSS -  Define a custom path for your own css file to use with
the theme.

- Tertiary Menus -  Currently not supported but possibly planned.

- Customizable layout width in the theme settings UI, go as wide as you
want! It's all percentage based within the parent container. That's one of
the drawbacks of Bamboo and there were a lot of feature requests for this.

- Main Menu block region Use this region if you turn off "Main Menu" in the
theme settings and use your own third party menu system such as Menu Block
or Superfish Module. You are responsible for any styling and CSS for this.
(Use local.css as mentioned above.)

- Pinch and Zoom for Touch friendly devices - Option to choose whether to
pinch and zoom on a touch sensitive device or not. Default is off. Note,
there is no support for layouts breaking or otherwise if you choose to
enable this option.

-- ADDITIONAL FEATURES --

- Mobile friendly off-canvas menu

- HTML5 Image captions on default imagefield, may work for others.

- Responsive for phone, tablet, and desktop using media queries

- Mobile, touch friendly menu

- Drop down menus (for desktop)

- Note for drop down / sub-menus to work, you need to set a main menu item
to "Show as expanded" in the Drupal menu settings UI. This setting is
located at /admin/structure/menu/item/xxx/edit where "xxx" is the id of
your menu item. Or simply go to: Administration > Structure > Menus > Main
menu and then click a menu item and edit. If you need help with this,
please consult Drupal core documentation.

-- REQUIREMENTS --

No base theme needed, simply use this theme on its own.

-- INSTALLATION --

Install as usual, see http://drupal.org/node/176045 for further
information.

-- CUSTOMIZATION --

* As with any other Drupal theme you are able to customize just about every
aspect of this theme but some nice defaults are provided out of the box
with gratis.

- drupal.org theme guide is here : http://drupal.org/documentation/theme

-- UPGRADING -- Nothing too tricky here other than if you have a local.css
or custom path CSS file as per the documentation. When upgrading, you must
preserve local.css somewhere, otherwise it could get overwritten with the
upgrade. After you upgrade, you can then drop local.css back in to the
theme. Of course if you have modified other files, they will all get
overwritten.

- In many cases, a subtheme is probably recommended then as opposed to
using local.css. You can create a sub-theme of your own to put all your
overrides in: "Creating a sub-theme" - http://drupal.org/node/225125 A
future version of this theme may allow for a custom path for local.css to
avoid upgrade snags.

-- NOTES --

This theme supports CSS3 / HTML5 and media queries. There is no support for
IE9 or below so please do not file any issues in regard to this.

If you require specific customizations that you are not able to do on your
own, I can offer paid support. Please email me: contact@highrockmedia.com
or through my website's contact form. http://dannyenglander.com/contact-us

Buy me a Latte - Help support gratis but it's not a requirement.
http://dannyenglander.com/buy-me-latte

------------------------ Danny Englander Drupal Themer and Photographer
San Diego, California http://dannyenglander.com
Photos: http://highrockphoto.com
