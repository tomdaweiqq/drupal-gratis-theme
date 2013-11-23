Version 1.2, September 15, 2013

-- SUMMARY --

Gratis is a responsive Drupal 7 HTML5 theme designed and developed by Danny
Englander (Twitter: @highrockmedia). Based on the CSS Unsemantic Framework,
it allows for a choice color palettes in the theme's settings page. There
also may be support in the future for the color module to choose your own
colors for various elements.

Gratis is aimed at users who want to get a nice looking theme up and
running in short order, may not want to take the time to create a sub-theme
and mess with regions, settings, media queries, and other highly technical
things. It's also aimed at a casual Drupal user who has some familiarity
with building sites. This theme also does not require any base theme.

-- Theme Dependency (NONE) -- 

As of Alpha 24, there is no longer a dependency on jQuery update.

-- CONFIGURATION --

- Configure theme settings in Administration > Appearance > Settings >
Gratis or admin/appearance/settings/Gratis and choose various options
available.

-- THEME SETTINGS UI --

- Choice of several color palettes: Turquoise Blue, Cool Purple, Pumpkin
Orange, Olive Green, Pomegranate Red, Seafoam Green, Green Gray

- Toggle Breadcrumbs on or off

LOGOS
- Default theme logo changes for each color palette.
- You can also toggle this off and use your own logo. Do this by 
Unchecking in the theme settings, "Use theme Logo?". Once you
do this and upload your own logo, it should now display and 
override the default logo.

*** Note, it's hard to anticipate what effect various shapes and sizes of a 
custom uploaded logo will have on the theme so unfortunately support 
cannot be offered through the issue queue for things
like this.

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

- ADMIN PAGES
Gratis should work reasonably well with admin pages and will continue to
be improved for those. NOTE, you cannot or should not use Gratis for the
admin theme if you have the overlay module enabled. It will simply not
work and is beyond the scope of this project. if you want to use the Overlay,
then use a dedicated admin theme that is Overlay ready such as Seven or
Adminimal.

- Node block region Use this region to have a block region within a node
which will appear right after the content but before any node links or
comments. Useful for ads or otherwise. Note, to use this and for this
region to work properly, you must at least be using the standard Drupal 7
field_body field, otherwise this region will simply sit below whatever
blocks are assigned to the content region.

- Pinch and Zoom for Touch friendly devices - Option to choose whether to
pinch and zoom on a touch sensitive device or not. Default is off. Note,
there is no support for layouts breaking or otherwise if you choose to
enable this option.

***** A note about the "Top Panel" block region ***** - This block region
within the theme does not really have any styling so I would not recommend
using this unless you want to add your own extra styling and jQuery. This
was done on purpose for some custom modules that I use in concert with this
block region.

-- ADDITIONAL FEATURES --

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
with Gratis.

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
IE8 and below so please do not file any issues in regard to this.

If you require specific customizations that you are not able to do on your
own, I can offer paid support. Please email me: contact@highrockmedia.com
or through my website's contact form. http://highrockmedia.com/contact-us

Buy me a Latte - Help support Gratis but it's not a requirement.
http://highrockmedia.com/buy-me-latte

------------------------ Danny Englander Drupal Themer and Photographer
High Rock Media San Diego, California http://highrockmedia.com
http://highrockphoto.com
