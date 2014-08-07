##
## This file is only needed for Compass/Sass integration. If you are not using
## Compass, you may safely ignore or delete this file.
##
## If you'd like to learn more about Sass and Compass, see the sass/README.txt
## file for more information.
##

# Default to development if environment is not set.
saved = environment
if (environment.nil?)
  environment = :development
else
  environment = saved
end

http_path = "/"

# Location of the theme's resources.
css_dir = "css"
sass_dir = "sass"
images_dir = "images"
generated_images_dir = images_dir + "/generated"
javascripts_dir = "js"

# Require any additional compass plugins installed on your system.
require 'compass-normalize'
require 'rgbapng'
require 'toolkit'
require 'susy'
require 'sass-globbing'
require 'font-awesome-sass'
require 'sass-media_query_combiner'
require 'breakpoint'

# To enable relative paths to assets via compass helper functions. Since Drupal
# themes can be installed in multiple locations, we don't need to worry about
# the absolute path to the theme from the server omega.
relative_assets = true

# Conditionally enable line comments when in development mode.
line_comments = false
disable_warnings = true

# Output debugging info in development mode.
#sass_options = (environment == :production) ? {} : {:debug_info => true}

# Add the 'sass' directory itself as an import path to ease imports.
add_import_path 'sass'

# You can select your preferred output style here (:expanded, :nested, :compact
# or :compressed).
# output_style = (environment == :production) ? :expanded : :nested

#set a pretty output style.
output_style = :expanded

sass_options = {:sourcemap => true}
enable_sourcemaps = true

firesass = true

#environment = :development
environment = :production
