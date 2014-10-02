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
function gratis_preprocess_html(&$variables) {

  // Postscript columns.
  if (!empty($variables['page']['preface_first']) && !empty($variables['page']['preface_second']) && !empty($variables['page']['preface_third'])) {
    $variables['classes_array'][] = 'preface-three';
  }
  elseif (!empty($variables['page']['preface_first']) && !empty($variables['page']['preface_second'])) {
    $variables['classes_array'][] = 'preface-two';
  }
  elseif (!empty($variables['page']['preface_first']) && !empty($variables['page']['preface_third'])) {
    $variables['classes_array'][] = 'preface-two';
  }
  elseif (!empty($variables['page']['preface_second']) && !empty($variables['page']['preface_third'])) {
    $variables['classes_array'][] = 'preface-two';
  }
  else {
    $variables['classes_array'][] = 'preface-one';
  }

  // Postscript columns.
  if (!empty($variables['page']['postscript_first']) && !empty($variables['page']['postscript_second']) && !empty($variables['page']['postscript_third'])) {
    $variables['classes_array'][] = 'postscript-three';
  }
  elseif (!empty($variables['page']['postscript_first']) && !empty($variables['page']['postscript_second'])) {
    $variables['classes_array'][] = 'postscript-two';
  }
  elseif (!empty($variables['page']['postscript_first']) && !empty($variables['page']['postscript_third'])) {
    $variables['classes_array'][] = 'postscript-two';
  }
  elseif (!empty($variables['page']['postscript_second']) && !empty($variables['page']['postscript_third'])) {
    $variables['classes_array'][] = 'postscript-two';
  }
  else {
    $variables['classes_array'][] = 'postscript-one';
  }

  // Footer columns.
  if (!empty($variables['page']['footer_first']) && !empty($variables['page']['footer_second']) && !empty($variables['page']['footer_third'])) {
    $variables['classes_array'][] = 'footer-three';
  }
  elseif (!empty($variables['page']['footer_first']) && !empty($variables['page']['footer_second'])) {
    $variables['classes_array'][] = 'footer-two';
  }
  elseif (!empty($variables['page']['footer_first']) && !empty($variables['page']['footer_third'])) {
    $variables['classes_array'][] = 'footer-two';
  }
  elseif (!empty($variables['page']['footer_second']) && !empty($variables['page']['footer_third'])) {
    $variables['classes_array'][] = 'footer-two';
  }
  else {
    $variables['classes_array'][] = 'footer-one';
  }

  $variables['html_attributes_array'] = array();
  $variables['body_attributes_array'] = array();

  // HTML element attributes.
  $variables['html_attributes_array']['lang'] = $variables['language']->language;
  $variables['html_attributes_array']['dir'] = $variables['language']->dir;

  // Adds RDF namespace prefix bindings in the form of an RDFa 1.1 prefix
  // attribute inside the html element.
  if (function_exists('rdf_get_namespaces')) {
    $variables['rdf'] = new stdClass();
    $variables['rdf']->prefix = '';
    foreach (rdf_get_namespaces() as $prefix => $uri) {
      $variables['rdf']->prefix .= $prefix . ': ' . $uri . "\n";
    }
    $variables['html_attributes_array']['prefix'] = $variables['rdf']->prefix;
  }

  // BODY element attributes.
  $variables['body_attributes_array']['class'] = $variables['classes_array'];
  $variables['body_attributes_array'] += $variables['attributes_array'];
  $variables['attributes_array'] = '';

  // Add font awesome cdn.
  drupal_add_css('//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.css', array('type' => 'external'));

  // Vars for empty / checked / not empty site name and slogan.
  $variables['hide_site_name'] = theme_get_setting('toggle_name') ? FALSE : TRUE;
  $variables['hide_site_slogan'] = theme_get_setting('toggle_slogan') ? FALSE : TRUE;

  if ($variables['hide_site_name']) {
    $variables['classes_array'][] = 'site-name-hidden';
  }
  else {
    $variables['classes_array'][] = 'site-name-show';
  }

  if ($variables['hide_site_slogan']) {
    $variables['classes_array'][] = 'site-slogan-hidden';
  }
  else {
    $variables['classes_array'][] = 'site-slogan-show';
  }

  if (variable_get('site_slogan', '')) {
    $variables['classes_array'][] = 'site-slogan-not-empty';
  }
  else {
    $variables['classes_array'][] = 'site-slogan-empty';
  }

  // Extra body classes for theme variables.
  // Color palette.
  $file = theme_get_setting('theme_color_palette');
  $variables['classes_array'][] = drupal_html_class('color-palette-' . $file);

  // Typography.
  if (theme_get_setting('gratis_setfonts') == TRUE) {
    // Heading typeface.
    $file = theme_get_setting('gratis_heading_typeface');
    $variables['classes_array'][] = drupal_html_class('heading-typeface-' . $file);

    // Body typeface.
    $file = theme_get_setting('gratis_body_typeface');
    $variables['classes_array'][] = drupal_html_class('body-typeface-' . $file);
  }

  // Layout options.
  if (theme_get_setting('gratis_header_layout') == TRUE) {
    $variables['classes_array'][] = 'header-left-right';
  }

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

  $variables['scripts'] = drupal_get_js();

  // Add various classes for common site paths.
  if ($node = menu_get_object()) {
    $variables['classes_array'][] = 'is-node';
  }
  else {
    $variables['classes_array'][] = 'not-node';
  }

  if (theme_get_setting('theme_color_palette') == 'chartreuse' || 'caribe' || 'maillot-jaune') {
    $variables['classes_array'][] = 'dark-bg';
  }

}

/**
 * Override or insert variables into the page template.
 */
function gratis_preprocess_page(&$variables, $hook) {
  // Check if it's a node and set a variable.
  $variables['is_node'] = FALSE;
  if ($node = menu_get_object()) {
    $variables['is_node'] = TRUE;
  }

  // Set the custom grid width in a variable.
  $set_width = filter_xss_admin(theme_get_setting('gratis_grid_container_width'));
    if (!empty($set_width)) {
    $variables['set_width'] = check_plain('style=max-width:' . $set_width . '; ');
  }

  $min_height = filter_xss_admin(theme_get_setting('gratis_min_height_setting'));
  if (!empty($min_height)) {
    $variables['min_height'] = check_plain('style=min-height:' . $min_height . 'px; ');
  }

  // Primary nav.
  $variables['primary_nav'] = FALSE;
  if ($variables['main_menu']) {
    // Build links.
    $variables['primary_nav'] = menu_tree(variable_get('menu_main_links_source', 'main-menu'));
    // Provide default theme wrapper function.
    // Sets up function gratis_menu_tree__primary in menu.inc.
    $variables['primary_nav']['#theme_wrappers'] = array('menu_tree__primary');
  }
}

/**
 * Implements hook_preprocess_node().
 *
 * Copied from Sam Richard's Aurora Base Theme.
 *
 * Backports the following changes made to Drupal 8:
 * - #1077602: Convert node.tpl.php to HTML5.
 */
function gratis_preprocess_node(&$variables, $hook) {
  // Global node.
  $node = $variables['node'];
  $css_node_type = drupal_clean_css_identifier($variables['type']);
  $css_view_mode = drupal_clean_css_identifier($variables['view_mode']);
  // Add article ARIA role.
  $variables['attributes_array']['role'] = 'article';
  // Add BEM element classes.
  $variables['title_attributes_array']['class'][] = 'node-title';
  $variables['content_attributes_array']['class'][] = 'node-content';
  $variables['content']['links']['#attributes']['class'][] = 'node-links';
  // Change modifier classes to use BEM syntax.
  $variables['classes_array'] = preg_replace('/^node-' . $css_node_type . '$/', 'node--' . $css_node_type, $variables['classes_array']);
  $variables['classes_array'] = preg_replace('/^node-promoted$/', 'node--promoted', $variables['classes_array']);
  $variables['classes_array'] = preg_replace('/^node-sticky$/', 'node--sticky', $variables['classes_array']);
  // Add modifier classes for view mode.
  $variables['classes_array'][] = 'node--' . $css_view_mode;
  $variables['classes_array'][] = 'node--' . $css_node_type . '--' . $css_view_mode;

  // Show only the username in submitted, the date is handled by node.tpl.php.
  $variables['submitted'] = t('By !username', array('!username' => $variables['name']));

  // Set date variables using drupal's format_date function.
  $variables['thedate'] = format_date($node->created, "custom", "j");
  $variables['themonth'] = format_date($node->created, "custom", "M");
  $variables['theyear'] = format_date($node->created, "custom", "Y");

  if ($variables['user_picture'] && $variables['display_submitted']) {
    $GLOBALS['conf']['user_picture_style'] = 'thumbnail';
    $variables['user_picture'] = theme('user_picture', array('account' => $variables['node']));
  }

}

/**
 * Preprocess variables for region.tpl.php
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("region" in this case.)
 */
function gratis_preprocess_region(&$variables, $hook) {
  // Sidebar regions get some extra classes and a common template suggestion.
  if (strpos($variables['region'], 'sidebar_') === 0) {
    $variables['classes_array'][] = 'column';
    $variables['classes_array'][] = 'l-region l-sidebar';
    // Allow a region-specific template to override region--sidebar.
    array_unshift($variables['theme_hook_suggestions'], 'region__sidebar');
  }
  // Use a template with no wrapper for the content region.
  elseif ($variables['region'] == 'content') {
    // Allow a region-specific template to override region--no-wrapper.
    array_unshift($variables['theme_hook_suggestions'], 'region__no_wrapper');
  }
  // Add a SMACSS-style class for header region.
  elseif ($variables['region'] == 'header') {
    array_unshift($variables['classes_array'], 'header__region');
  }
}

/**
 * Override or insert variables into the block templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("block" in this case.)
 */
function gratis_preprocess_block(&$variables, $hook) {
  // Use a template with no wrapper for the page's main content.
  if ($variables['block_html_id'] == 'block-system-main') {
    $variables['theme_hook_suggestions'][] = 'block__no_wrapper';
  }

  // Classes describing the position of the block within the region.
  if ($variables['block_id'] == 1) {
    $variables['classes_array'][] = 'first';
  }
  // The last_in_region property is set in gratis_page_alter().
  if (isset($variables['block']->last_in_region)) {
    $variables['classes_array'][] = 'last';
  }
  $variables['classes_array'][] = $variables['block_zebra'];

  $variables['title_attributes_array']['class'][] = 'block__title gamma';
  $variables['title_attributes_array']['class'][] = 'block-title';

}

/**
 * Override or insert variables into the block templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("block" in this case.)
 */
function gratis_process_block(&$variables, $hook) {
  // Drupal 7 should use a $title variable instead of $block->subject.
  $variables['title'] = isset($variables['block']->subject) ? $variables['block']->subject : '';
}

/**
 * Implements hook_process_html().
 */
function gratis_process_html(&$variables) {
  // Flatten out html_attributes and body_attributes.
  $variables['html_attributes'] = drupal_attributes($variables['html_attributes_array']);
  $variables['body_attributes'] = drupal_attributes($variables['body_attributes_array']);
}

/**
 * Process variables for comment.tpl.php.
 *
 * @see comment.tpl.php
 */
function gratis_preprocess_comment(&$variables) {
  $variables['created'] = date('m / j / y', $variables['elements']['#comment']->created);
  $variables['changed'] = date('m / j / y', $variables['elements']['#comment']->created);
}

/**
 * Preprocesses variables for theme_username().
 *
 * Modules that make any changes to variables like 'name' or 'extra' must insure
 * that the final string is safe to include directly in the output by using
 * check_plain() or filter_xss().
 *
 * @see template_process_username()
 */
function gratis_preprocess_username(&$variables) {
  // Update the username so it's the full name of the user.
  $account = $variables['account'];

  // Revise the name trimming done in template_preprocess_username.
  $name = $variables['name_raw'] = format_username($account);

  // Trim the altered name as core does, but with a higher character limit.
  if (drupal_strlen($name) > 35) {
    $name = drupal_substr($name, 0, 18) . '...';
  }

  // Assign the altered name to $variables['name'].
  $variables['name'] = check_plain($name);
}
