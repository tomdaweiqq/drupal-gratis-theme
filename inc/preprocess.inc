<?php

/**
 * @file
 * Custom preprocess functions and theme function overrides.
 *
 * If you need to add or modify theme functions do it in your sub-theme.
 */

/**
 * Implements hook_preprocess_html().
 */
function gratis_preprocess_html(&$vars) {

  // Postscript columns ('$pos_columns').
  if (!empty($vars['page']['postscript_first']) && !empty($vars['page']['postscript_second']) && !empty($vars['page']['postscript_third'])) {
    $vars['classes_array'][] = 'postscript-three';
  }
  elseif (!empty($vars['page']['postscript_first']) && !empty($vars['page']['postscript_second'])) {
    $vars['classes_array'][] = 'postscript-two';
  }
  elseif (!empty($vars['page']['postscript_first']) && !empty($vars['page']['postscript_third'])) {
    $vars['classes_array'][] = 'postscript-two';
  }
  elseif (!empty($vars['page']['postscript_second']) && !empty($vars['page']['postscript_third'])) {
    $vars['classes_array'][] = 'postscript-two';
  }
  else {
    $vars['classes_array'][] = 'postscript-one';
  }

  // Postscript columns ('$pre_columns').
  if (!empty($vars['page']['preface_first']) && !empty($vars['page']['preface_second']) && !empty($vars['page']['preface_third'])) {
    $vars['classes_array'][] = 'preface-three';
  }
  elseif (!empty($vars['page']['preface_first']) && !empty($vars['page']['preface_second'])) {
    $vars['classes_array'][] = 'preface-two';
  }
  elseif (!empty($vars['page']['preface_first']) && !empty($vars['page']['preface_third'])) {
    $vars['classes_array'][] = 'preface-two';
  }
  elseif (!empty($vars['page']['preface_second']) && !empty($vars['page']['preface_third'])) {
    $vars['classes_array'][] = 'preface-two';
  }
  else {
    $vars['classes_array'][] = 'preface-one';
  }

  $vars['html_attributes_array'] = array();
  $vars['body_attributes_array'] = array();

  // HTML element attributes.
  $vars['html_attributes_array']['lang'] = $vars['language']->language;
  $vars['html_attributes_array']['dir'] = $vars['language']->dir;

  // Adds RDF namespace prefix bindings in the form of an RDFa 1.1 prefix
  // attribute inside the html element.
  if (function_exists('rdf_get_namespaces')) {
    $vars['rdf'] = new stdClass();
    $vars['rdf']->prefix = '';
    foreach (rdf_get_namespaces() as $prefix => $uri) {
      $vars['rdf']->prefix .= $prefix . ': ' . $uri . "\n";
    }
    $vars['html_attributes_array']['prefix'] = $vars['rdf']->prefix;
  }

  // BODY element attributes.
  $vars['body_attributes_array']['class'] = $vars['classes_array'];
  $vars['body_attributes_array'] += $vars['attributes_array'];
  $vars['attributes_array'] = '';

  // Add font awesome cdn.
  drupal_add_css('//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.css', array('type' => 'external'));

  // Add a body class is the site name is hidden or not.
  if (theme_get_setting('toggle_name') == FALSE) {
    $vars['classes_array'][] = 'site-name-hidden';
  }
  else {
    $vars['classes_array'][] = 'site-name';
  }

  // Add a body class is the site slogan is hidden or not.
  if (theme_get_setting('toggle_slogan')) {
    $vars['classes_array'][] = 'site-slogan';
  }
  else {
    $vars['classes_array'][] = 'site-slogan-hidden';
  }

  // Extra body classes for theme variables.
  // The Color Palette.
  $file = theme_get_setting('theme_color_palette');
  $vars['classes_array'][] = drupal_html_class('color-palette-' . $file);

  // Local css within theme folder if checked.
  if (theme_get_setting('gratis_localcss') == TRUE) {
    drupal_add_css(path_to_theme() . '/css/local.css', array(
      'group' => CSS_THEME,
      'media' => 'screen',
      'preprocess' => TRUE,
      'weight' => '9997',
    ));
  }

  // Custom css file path if checked and file exists.
  if (theme_get_setting('gratis_custom_css_location') == TRUE) {
    $path = theme_get_setting('gratis_custom_css_path');
    if (file_exists($path)) {
      drupal_add_css("$path", array(
        'group' => CSS_THEME,
        'preprocess' => TRUE,
        'weight' => 9998,
      ));
    }
  }

  // Add general JS.
  drupal_add_js(drupal_get_path('theme', 'gratis') . '/js/scripts.js', array(
    'group' => JS_THEME,
    'preprocess' => TRUE,
    'weight' => '999',
  ));

  $vars['scripts'] = drupal_get_js();

  // Add various classes for common site paths.
  if ($node = menu_get_object()) {
    $vars['classes_array'][] = 'is-node';
  }
  else {
    $vars['classes_array'][] = 'not-node';
  }

}

/**
 * Override or insert variables into the page template.
 */
function gratis_preprocess_page(&$vars, $hook) {
  // Check if it's a node and set a variable.
  $vars['is_node'] = FALSE;
  if ($node = menu_get_object()) {
    $vars['is_node'] = TRUE;
  }

  // Set the custom grid width in a variable.
  $gridwidth = theme_get_setting('gratis_grid_container_width');
  $vars['setwidth'] = $gridwidth;

  // Primary nav.
  $vars['primary_nav'] = FALSE;
  if ($vars['main_menu']) {
    // Build links.
    $vars['primary_nav'] = menu_tree(variable_get('menu_main_links_source', 'main-menu'));
    // Provide default theme wrapper function.
    $vars['primary_nav']['#theme_wrappers'] = array('menu_tree__primary');
  }
}
