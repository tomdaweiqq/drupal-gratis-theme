<?php

/**
 * @file
 * theme-settings.php provides the custom theme settings
 *
 * Provides the checkboxes for the CSS overrides functionality
 * as well as the serif/sans-serif style option.
 */

/**
 * Implements hook_form_FORM_ID_alter().
 */
function gratis_form_system_theme_settings_alter(&$form, &$form_state, $form_id = NULL) {

  // @ theme_form_system_theme_settings_alter() name-clash.
  // See http://drupal.org/node/943212.
  if (isset($form_id)) {
    return;
  }

  // Form alters to put drupal settings in vertical tabs.
  $form['logo']['#group'] = 'gratis_settings';
  unset($form['logo']['#attributes']['class']);
  $form['favicon']['#group'] = 'gratis_settings';
  $form['theme_settings']['#group'] = 'gratis_settings';

  // Set the vertical tabs up.
  $form['gratis_settings'] = array(
    '#type' => 'vertical_tabs',
    '#weight' => 99,
  );

  // Gratis typography.
  // @todo
  $form['gratis_typography'] = array(
    '#type' => 'fieldset',
    '#title' => t('Gratis typography'),
    '#collapsible' => TRUE,
    '#group' => 'gratis_settings',
    '#description' => t('Choose typography settings for Gratis.'),
  );


  $form['gratis_typography']['gratis_heading_typeface'] = array(
    '#type' => 'select',
    '#title' => t('Choose a heading typeface'),
    '#default_value' => theme_get_setting('gratis_heading_typeface'),
    '#options' => array(
      'opensans' => t('Open Sans (modern clean sans-serif)'),
      'garamond' => t('EB Garamond (tradtional serif)'),
      'imfell' => t('IM Fell (antique style)'),
    ),
  );

  $form['gratis_typography']['gratis_body_typeface'] = array(
    '#type' => 'select',
    '#title' => t('Choose a body typeface'),
    '#default_value' => theme_get_setting('gratis_body_typeface'),
    '#options' => array(
      'opensans' => t('Open Sans (modern clean sans-serif)'),
      'garamond' => t('EB Garamond (tradtional serif)'),
    ),
  );

  // Gratis color settings tab area.
  $form['gratis_color_settings'] = array(
    '#type' => 'fieldset',
    '#title' => t('Gratis color settings'),
    '#collapsible' => TRUE,
    '#group' => 'gratis_settings',
    '#description' => t("Set the theme color palette for Gratis from the list below."),
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
      'royal-turquoise' => t('Royal Turquoise'),
    ),
  );

  // gratis additional settings.
  $form['gratis_css'] = array(
    '#type' => 'fieldset',
    '#title' => t('Gratis css settings'),
    '#collapsible' => TRUE,
    '#group' => 'gratis_settings',
  );

  $form['gratis_css']['gratis_localcss'] = array(
    '#type' => 'checkbox',
    '#title' => t('Use local.css?'),
    '#default_value' => theme_get_setting('gratis_localcss', 'gratis'),
    '#description' => t("This setting allows you to use your own custom css file within the gratis
theme folder. Only check this box if you have renamed local.sample.css to local.css.
You must clear the Drupal cache after doing this."),
  );

  $form['gratis_css']['custom_css_path_settings'] = array(
    '#type' => 'fieldset',
    '#title' => t('Custom css path settings'),
    '#collapsible' => FALSE,
  );

  $form['gratis_css']['custom_css_path_settings']['custom_css_path']['gratis_custom_css_location'] = array(
    '#type' => 'checkbox',
    '#title' => t('Only check the box if you want to specify a custom path below to your local css file.'),
    '#default_value' => theme_get_setting('gratis_custom_css_location', 'gratis'),
  );

  $form['gratis_css']['custom_css_path_settings']['custom_css_path']['gratis_custom_css_path'] = array(
    '#type' => 'textfield',
    '#title' => t('Path to Custom Stylesheet'),
    '#description' => t('Specify a custom path to the local.css file without the leading slash:
e.g.: sites/default/files/custom-css/local.css you must check the box above for this to work.'),
    '#default_value' => theme_get_setting('gratis_custom_css_path', 'gratis'),
  );

  $form['gratis_gridwidth'] = array(
    '#type' => 'fieldset',
    '#title' => t('Gratis grid width'),
    '#collapsible' => TRUE,
    '#group' => 'gratis_settings',
  );

  $form['gratis_gridwidth']['gratis_grid_container_width'] = array(
    '#type' => 'textfield',
    '#title' => t('Optional grid width value. e.g 1020px, 100% etc...'),
    '#default_value' => theme_get_setting('gratis_grid_container_width', 'gratis'),
    '#description' => t('This setting allows you to set the width of the entire gird container.
Leave blank for the default max width of 1200px.  All inner grids are percentage based
so this should work with most any value you set within reason.'),
  );

  $form['gratis_breadcrumb'] = array(
    '#type' => 'fieldset',
    '#title' => t('Gratis breadcrumbs'),
    '#collapsible' => TRUE,
    '#group' => 'gratis_settings',
  );

  $form['gratis_breadcrumb']['breadcrumb'] = array(
    '#type' => 'checkbox',
    '#title' => t('Show page breadcrumbs'),
    '#default_value' => theme_get_setting('breadcrumb', 'gratis'),
    '#description' => t("Check this option to show page breadcrumbs. Uncheck to hide."),
  );

  $form['gratis_touch'] = array(
    '#type' => 'fieldset',
    '#title' => t('Gratis touch device'),
    '#collapsible' => TRUE,
    '#group' => 'gratis_settings',
  );

  $form['gratis_touch']['gratis_viewport'] = array(
    '#type' => 'checkbox',
    '#title' => t('Use Touch device pinch and zoom?'),
    '#default_value' => theme_get_setting('gratis_viewport', 'gratis'),
    '#description' => t('Check this box ONLY if you want to enable touch device users to be able to pinch and zoom.'),
  );

}
