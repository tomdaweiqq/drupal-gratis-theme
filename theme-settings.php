<?php

/**
 * @file
 * Custom theme settings.
 */

/**
 * Implements hook_form_system_theme_settings_alter().
 *
 * @param $form
 *   Nested array of form elements that comprise the form.
 *
 * @param $form_state
 *   A keyed array containing the current state of the form.
 */

function gratis_form_system_theme_settings_alter(&$form, $form_state, $form_id = NULL) {

  // Set the vertical tabs up.
  $form['gratis_settings'] = array(
    '#type' => 'vertical_tabs',
    '#weight' => 99,
  );

  // Gratis color settings tab area.
  $form['gratis_color_settings'] = array(
    '#type' => 'details',
    '#title' => t('Gratis color settings'),
    '#collapsible' => TRUE,
    '#group' => 'gratis_settings',
    '#description' => t("Set the theme color palette for gratis from the list below."),
  );

  $form['gratis_color_settings']['theme_color_palette'] = array(
    '#type' => 'select',
    '#title' => t('Choose a color palette'),
    '#default_value' => theme_get_setting('theme_color_palette'),
    '#options' => array(
      'turquoise' => t('Turquoise Blue'),
      'purple' => t('Cool Purple'),
      'orange' => t('Pumpkin Orange'),
      'green' => t('Olive Green'),
      'pomegranate' => t('Pomegranate Red'),
      'seafoam' => t('Seafoam Green'),
      'greengray' => t('Green Gray'),
      'pink' => t('Pink'),
      'mustard' => t('Mustard'),
      'surf_green' => t('Surf Green'),
      'maillot_jaune' => t('Maillot Jaune (Dark background)'),
      'caribe' => t('Caribe (Dark background)'),
      'chartreuse' => t('Chartreuse (Dark background)'),
      'mediterranean_red' => t('Mystic Blue (Dark background)'),
    ),
  );

  $form['gratis_css'] = array(
    '#type' => 'details',
    '#title' => t('Gratis css settings'),
    '#collapsible' => TRUE,
    '#group' => 'gratis_settings',
  );

  $form['gratis_css']['gratis_localcss'] = array(
    '#type' => 'checkbox',
    '#title' => t('Use local.css?'),
    '#default_value' => theme_get_setting('gratis_localcss'),
    '#description' => t("This setting allows you to use your own custom css file within the gratis
theme folder. Only check this box if you have renamed local.sample.css to local.css.
You must clear the Drupal cache after doing this."),
  );

  $form['gratis_css']['gratis_header_layout'] = array(
    '#type' => 'checkbox',
    '#title' => t('Gratis Header Layout'),
    '#default_value' => theme_get_setting('gratis_header_layout'),
    '#description' => t("Check this option to have the header logo left and the site slogan right. (default is both centered"),
  );

  $form['gratis_gridwidth'] = array(
    '#type' => 'details',
    '#title' => t('Gratis page width and style'),
    '#collapsible' => TRUE,
    '#group' => 'gratis_settings',
  );

  $form['gratis_gridwidth']['gratis_grid_container_width'] = array(
    '#type' => 'textfield',
    '#title' => t('Optional grid width value. e.g 1020px, 100% etc...'),
    '#default_value' => theme_get_setting('gratis_grid_container_width'),
    '#description' => t('This setting allows you to set the width of the entire gird container.
Leave blank for the default max width of 1064px.  All inner grids are percentage based
so this should work with most any value you set within reason.'),
  );

  $form['gratis_gridwidth']['gratis_page_style'] = array(
    '#type' => 'select',
    '#title' => t('Choose a page style'),
    '#default_value' => theme_get_setting('gratis_page_style'),
    '#options' => array(
      'default' => t('Default'),
      'boxed' => t('Boxed'),
    ),
    '#description' => t("Default appears as a full width layout with a container within. Boxed
    appears more as a fixed width container, yet is still responsive. With boxed, you can
    utilize background tints and patterns for wider screen layouts."),
  );

  // Gratis bg patterns settings.
  $form['gratis_bg_settings'] = array(
    '#type' => 'details',
    '#title' => t('Gratis boxed layout background settings'),
    '#collapsible' => TRUE,
    '#group' => 'gratis_settings',
    '#description' => t("Choose a background pattern. These will only show if you choose 'Boxed Layout.'"),
  );

  $form['gratis_bg_settings']['theme_bg_pattern'] = array(
    '#type' => 'select',
    '#title' => t('Choose a background pattern'),
    '#default_value' => theme_get_setting('theme_bg_pattern'),
    '#description' => t("See the theme page for patterns key"),
    '#options' => array(
      'bg_pattern_01' => t('Background pattern 1'),
      'bg_pattern_02' => t('Background pattern 2'),
      'bg_pattern_03' => t('Background pattern 3'),
      'bg_pattern_04' => t('Background pattern 4'),
      'bg_pattern_05' => t('Background pattern 5'),
      'bg_pattern_06' => t('Background pattern 6'),
      'bg_pattern_07' => t('Background pattern 7'),
      'bg_pattern_08' => t('Background pattern 8'),
      'bg_pattern_09' => t('Background pattern 9'),
      'bg_pattern_10' => t('Background pattern 10'),
      'bg_pattern_11' => t('Background pattern 11'),
      'bg_pattern_12' => t('Background pattern 12'),
      'bg_pattern_13' => t('Background pattern 13'),
      'bg_pattern_14' => t('Background pattern 14'),
      'bg_pattern_15' => t('Background pattern 15'),
    ),
  );

  $form['gratis_bg_settings']['theme_bg_tint'] = array(
    '#type' => 'select',
    '#title' => t('Background Tint'),
    '#default_value' => theme_get_setting('theme_bg_tint'),
    '#description' => t("Choose a tint hue for your background"),
    '#options' => array(
      'no_tint' => t('None'),
      'bg_tint_turquoise' => t('Tint Turquoise Blue'),
      'bg_tint_purple' => t('Tint Cool Purple'),
      'bg_tint_orange' => t('Tint Pumpkin Orange'),
      'bg_tint_green' => t('Tint Olive Green'),
      'bg_tint_pomegranate' => t('Tint Pomegranate Red'),
      'bg_tint_seafoam' => t('Tint Seafoam Green'),
      'bg_tint_greengray' => t('Tint Green Gray'),
      'bg_tint_pink' => t('Tint Pink'),
      'bg_tint_mustard' => t('Tint Mustard'),
      'bg_tint_surf_green' => t('Tint Surf Green'),
      'bg_tint_maillot_jaune' => t('Tint Maillot Jaune'),
      'bg_tint_caribe' => t('Tint Caribe'),
      'bg_tint_chartreuse' => t('Tint Chartreuse'),
      'bg_tint_mediterranean_red' => t('Tint Mystic Blue'),
    ),
  );

  $form['gratis_breadcrumb'] = array(
    '#type' => 'details',
    '#title' => t('Gratis breadcrumbs'),
    '#collapsible' => TRUE,
    '#group' => 'gratis_settings',
  );

  $form['gratis_breadcrumb']['breadcrumb'] = array(
    '#type' => 'checkbox',
    '#title' => t('Show page breadcrumbs'),
    '#default_value' => theme_get_setting('breadcrumb'),
    '#description' => t("Check this option to show page breadcrumbs. Uncheck to hide."),
  );

  // Gratis additional settings.
  $form['gratis_js'] = array(
    '#type' => 'details',
    '#title' => t('Gratis JS settings'),
    '#collapsible' => TRUE,
    '#group' => 'gratis_settings',
  );

  $form['gratis_js']['gratis_browsersync'] = array(
    '#type' => 'checkbox',
    '#title' => t('Use Browsersync?'),
    '#default_value' => theme_get_setting('gratis_browsersync'),
    '#description' => t('Check this box to use browsersync. (Recommended for local development only.)'),
  );

  $form['gratis_js']['gratis_minifiedjs'] = array(
    '#type' => 'checkbox',
    '#title' => t('Use minified js scripts file?'),
    '#default_value' => theme_get_setting('gratis_minifiedjs'),
    '#description' => t('Check this box and the site will use the generated minified custom JS file within the theme.'),
  );

  // Gratis typography.
  $form['gratis_typography'] = array(
    '#type' => 'details',
    '#title' => t('Gratis typography'),
    '#collapsible' => TRUE,
    '#group' => 'gratis_settings',
  );

  $form['gratis_typography']['gratis_setfonts'] = array(
    '#type' => 'checkbox',
    '#title' => t("Would you like to use Gratis' default typography?"),
    '#default_value' => theme_get_setting('gratis_setfonts'),
    '#description' => t("Check this box to use Gratis' built-in fonts, leave unchecked to use the @font-your-face module or other font providers."),
  );

  $form['gratis_typography']['gratis_typography_settings'] = array(
    '#type' => 'details',
    '#title' => t('Font choices'),
    '#collapsible' => TRUE,
    '#description' => t('Choose your fonts.'),
    '#states' => array(
      'visible' => array(
        ':input[name="gratis_setfonts"]' => array('checked' => TRUE),
      ),
    ),
  );

  $form['gratis_typography']['gratis_typography_settings']['gratis_heading_typeface'] = array(
    '#type' => 'select',
    '#title' => t('Choose a heading typeface'),
    '#default_value' => theme_get_setting('gratis_heading_typeface'),
    '#options' => array(
      'opensans' => t('Open Sans (modern clean sans-serif)'),
      'garamond' => t('EB Garamond (tradtional serif)'),
      'imfell' => t('IM Fell (antique style)'),
    ),
  );

  $form['gratis_typography']['gratis_typography_settings']['gratis_body_typeface'] = array(
    '#type' => 'select',
    '#title' => t('Choose a body typeface'),
    '#default_value' => theme_get_setting('gratis_body_typeface'),
    '#options' => array(
      'opensans' => t('Open Sans (modern clean sans-serif)'),
      'garamond' => t('EB Garamond (tradtional serif)'),
    ),
  );
}
