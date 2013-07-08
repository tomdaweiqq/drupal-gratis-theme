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
function gratis_form_system_theme_settings_alter(&$form, &$form_state) {

  $form['gratis_settings'] = array(
    '#type' => 'fieldset',
    '#title' => t('gratis Theme Settings'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  );

  $form['gratis_settings']['breadcrumb'] = array(
    '#type' => 'checkbox',
    '#title' => t('Show page breadcrumbs'),
    '#default_value' => theme_get_setting('breadcrumb', 'gratis'),
    '#description' => t("Check this option to show page breadcrumbs. Uncheck to hide."),
  );

  $form['gratis_settings']['general_settings']['gratis_themelogo'] = array(
    '#type' => 'checkbox',
    '#title' => t('Use theme Logo?'),
    '#default_value' => theme_get_setting('gratis_themelogo', 'gratis'),
    '#description' => t("Check for yes, uncheck to upload your own logo!"),
  );

  $form['gratis_settings']['general_settings']['theme_color_config']['theme_color_palette'] = array(
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
    ),
  );

  $form['additional_settings'] = array(
    '#type' => 'fieldset',
    '#title' => t('Additional gratis Settings'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  );

  $form['additional_settings']['other_settings']['gratis_localcss'] = array(
    '#type' => 'checkbox',
    '#title' => t('Use local.css?'),
    '#default_value' => theme_get_setting('gratis_localcss', 'gratis'),
    '#description' => t("This setting allows you to use your own custom css file within the gratis
    theme folder. Only check this box if you have renamed local.sample.css to local.css.
    You must clear the Drupal cache after doing this."),
  );

  $form['additional_settings']['other_settings']['gratis_grid_container_width'] = array(
    '#type' => 'textfield',
    '#title' => t('Optional grid width value. e.g 1020px, 100% etc...'),
    '#default_value' => theme_get_setting('gratis_grid_container_width', 'gratis'),
    '#description' => t("This setting allows you to set the width of the entire gird container. 
      Leave blank for the default max width of 1200px.  All inner grids are percentage based 
      so this should work with most any value you set within reason. 
      <strong style='color: #cc0000;'>*** Warning, only use this if you know what 
      you are doing!</strong>"),
  );

  $form['additional_settings']['other_settings']['gratis_viewport'] = array(
    '#type' => 'checkbox',
    '#title' => t('Use Touch device pinch and zoom?'),
    '#default_value' => theme_get_setting('gratis_viewport', 'gratis'),
    '#description' => t("** Check this box ONLY if you want to enable touch device users to be able to pinch and zoom.
    Note this is purely experimental and if you enable this, there is no support for layouts breaking."),
  );

  $form['custom_css_path_settings'] = array(
    '#type' => 'fieldset',
    '#title' => t('Custom CSS Path Settings'),
    '#description' => t("<strong style='color: #cc0000;'>Note only use this feature if you know what you are doing!</strong>"),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  );

  $form['custom_css_path_settings']['custom_css_path']['gratis_custom_css_location'] = array(
    '#type' => 'checkbox',
    '#title' => t('Only check the box if you want to specify a custom path below to your local css file.'),
    '#default_value' => theme_get_setting('gratis_custom_css_location', 'gratis'),
  );

  $form['custom_css_path_settings']['custom_css_path']['gratis_custom_css_path'] = array(
    '#type' => 'textfield',
    '#title' => t('Path to Custom Stylesheet'),
    '#description' => t('Specify a custom path to the local.css file without the leading slash:
    e.g.: sites/default/files/custom-css/local.css you must check the box above for this to work.'),
    '#default_value' => theme_get_setting('gratis_custom_css_path', 'gratis'),
  );

}
