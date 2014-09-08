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

  // Postscript columns.
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

  // Postscript columns.
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

  // Footer columns.
  if (!empty($vars['page']['footer_first']) && !empty($vars['page']['footer_second']) && !empty($vars['page']['footer_third'])) {
    $vars['classes_array'][] = 'footer-three';
  }
  elseif (!empty($vars['page']['footer_first']) && !empty($vars['page']['footer_second'])) {
    $vars['classes_array'][] = 'footer-two';
  }
  elseif (!empty($vars['page']['footer_first']) && !empty($vars['page']['footer_third'])) {
    $vars['classes_array'][] = 'footer-two';
  }
  elseif (!empty($vars['page']['footer_second']) && !empty($vars['page']['footer_third'])) {
    $vars['classes_array'][] = 'footer-two';
  }
  else {
    $vars['classes_array'][] = 'footer-one';
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

  // Vars for empty / checked / not empty site name and slogan.
  $vars['hide_site_name'] = theme_get_setting('toggle_name') ? FALSE : TRUE;
  $vars['hide_site_slogan'] = theme_get_setting('toggle_slogan') ? FALSE : TRUE;

  if ($vars['hide_site_name']) {
    $vars['classes_array'][] = 'site-name-hidden';
  }
  else {
    $vars['classes_array'][] = 'site-name-show';
  }

  if ($vars['hide_site_slogan']) {
    $vars['classes_array'][] = 'site-slogan-hidden';
  }
  else {
    $vars['classes_array'][] = 'site-slogan-show';
  }

  if (variable_get('site_slogan', '')) {
    $vars['classes_array'][] = 'site-slogan-not-empty';
  }
  else {
    $vars['classes_array'][] = 'site-slogan-empty';
  }

  // Extra body classes for theme variables.
  // Color palette.
  $file = theme_get_setting('theme_color_palette');
  $vars['classes_array'][] = drupal_html_class('color-palette-' . $file);

  // Typography.
  if (theme_get_setting('gratis_setfonts') == TRUE) {
    // Heading typeface.
    $file = theme_get_setting('gratis_heading_typeface');
    $vars['classes_array'][] = drupal_html_class('heading-typeface-' . $file);

    // Body typeface.
    $file = theme_get_setting('gratis_body_typeface');
    $vars['classes_array'][] = drupal_html_class('body-typeface-' . $file);
  }

  // Layout options.
  if (theme_get_setting('gratis_header_layout') == TRUE) {
    $vars['classes_array'][] = 'header-left-right';
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

  $vars['scripts'] = drupal_get_js();

  // Add various classes for common site paths.
  if ($node = menu_get_object()) {
    $vars['classes_array'][] = 'is-node';
  }
  else {
    $vars['classes_array'][] = 'not-node';
  }

  if (theme_get_setting('theme_color_palette') == 'chartreuse' || 'caribe' || 'maillot-jaune') {
    $vars['classes_array'][] = 'dark-bg';
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
    // Sets up function gratis_menu_tree__primary in menu.inc.
    $vars['primary_nav']['#theme_wrappers'] = array('menu_tree__primary');
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
function gratis_preprocess_node(&$vars, $hook) {
  // Global node.
  $node = $vars['node'];
  $css_node_type = drupal_clean_css_identifier($vars['type']);
  $css_view_mode = drupal_clean_css_identifier($vars['view_mode']);
  // Add article ARIA role.
  $vars['attributes_array']['role'] = 'article';
  // Add BEM element classes.
  $vars['title_attributes_array']['class'][] = 'node-title';
  $vars['content_attributes_array']['class'][] = 'node-content';
  $vars['content']['links']['#attributes']['class'][] = 'node-links';
  // Change modifier classes to use BEM syntax.
  $vars['classes_array'] = preg_replace('/^node-' . $css_node_type . '$/', 'node--' . $css_node_type, $vars['classes_array']);
  $vars['classes_array'] = preg_replace('/^node-promoted$/', 'node--promoted', $vars['classes_array']);
  $vars['classes_array'] = preg_replace('/^node-sticky$/', 'node--sticky', $vars['classes_array']);
  // Add modifier classes for view mode.
  $vars['classes_array'][] = 'node--' . $css_view_mode;
  $vars['classes_array'][] = 'node--' . $css_node_type . '--' . $css_view_mode;

  // Show only the username in submitted, the date is handled by node.tpl.php.
  $vars['submitted'] = t('By !username', array('!username' => $vars['name']));

  // Set date variables using drupal's format_date function.
  $vars['thedate'] = format_date($node->created, "custom", "j");
  $vars['themonth'] = format_date($node->created, "custom", "M");
  $vars['theyear'] = format_date($node->created, "custom", "Y");

  if ($vars['user_picture'] && $vars['display_submitted']) {
    $GLOBALS['conf']['user_picture_style'] = 'thumbnail';
    $vars['user_picture'] = theme('user_picture', array('account' => $vars['node']));
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
    // Allow a region-specific template to override Zen's region--sidebar.
    array_unshift($variables['theme_hook_suggestions'], 'region__sidebar');
  }
  // Use a template with no wrapper for the content region.
  elseif ($variables['region'] == 'content') {
    // Allow a region-specific template to override Zen's region--no-wrapper.
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

  // Add Aria Roles via attributes.
  switch ($variables['block']->module) {
    case 'system':
      switch ($variables['block']->delta) {
        case 'main':
          // Note: the "main" role goes in the page.tpl, not here.
          break;
        case 'help':
        case 'powered-by':
          $variables['attributes_array']['role'] = 'complementary';
          break;
        default:
          // Any other "system" block is a menu block.
          $variables['attributes_array']['role'] = 'navigation';
          break;
      }
      break;
    case 'menu':
    case 'menu_block':
    case 'blog':
    case 'book':
    case 'comment':
    case 'forum':
    case 'shortcut':
    case 'statistics':
      $variables['attributes_array']['role'] = 'navigation';
      break;
    case 'search':
      $variables['attributes_array']['role'] = 'search';
      break;
    case 'help':
    case 'aggregator':
    case 'locale':
    case 'poll':
    case 'profile':
      $variables['attributes_array']['role'] = 'complementary';
      break;
    case 'node':
      switch ($variables['block']->delta) {
        case 'syndicate':
          $variables['attributes_array']['role'] = 'complementary';
          break;
        case 'recent':
          $variables['attributes_array']['role'] = 'navigation';
          break;
      }
      break;
    case 'user':
      switch ($variables['block']->delta) {
        case 'login':
          $variables['attributes_array']['role'] = 'form';
          break;
        case 'new':
        case 'online':
          $variables['attributes_array']['role'] = 'complementary';
          break;
      }
      break;
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
function gratis_process_block(&$variables, $hook) {
  // Drupal 7 should use a $title variable instead of $block->subject.
  $variables['title'] = isset($variables['block']->subject) ? $variables['block']->subject : '';
}

/**
 * Implements hook_process_html().
 */
function gratis_process_html(&$vars) {
  // Flatten out html_attributes and body_attributes.
  $vars['html_attributes'] = drupal_attributes($vars['html_attributes_array']);
  $vars['body_attributes'] = drupal_attributes($vars['body_attributes_array']);
}

/**
 * Process variables for comment.tpl.php.
 *
 * @see comment.tpl.php
 */
function gratis_preprocess_comment(&$vars) {
  $vars['created'] = date('m / j / y', $vars['elements']['#comment']->created);
  $vars['changed'] = date('m / j / y', $vars['elements']['#comment']->created);
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
function gratis_preprocess_username(&$vars) {
  // Update the username so it's the full name of the user.
  $account = $vars['account'];

  // Revise the name trimming done in template_preprocess_username.
  $name = $vars['name_raw'] = format_username($account);

  // Trim the altered name as core does, but with a higher character limit.
  if (drupal_strlen($name) > 35) {
    $name = drupal_substr($name, 0, 18) . '...';
  }

  // Assign the altered name to $vars['name'].
  $vars['name'] = check_plain($name);
}
