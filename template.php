<?php
/**
 * @file
 * Template.php provides theme functions & overrides
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

  // Add opensans from Google fonts.
  // http://www.google.com/fonts#UsePlace:use/Collection:Open+Sans:400italic,600italic,700italic,400,600,700
  drupal_add_css('//fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,700italic,400,600,700', array('type' => 'external'));

  // Add font awesome cdn.
  drupal_add_css('//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css', array('type' => 'external'));

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

  // Add a body class is the theme logo is hidden or not.
  if (theme_get_setting('gratis_themelogo') == TRUE) {
    $vars['classes_array'][] = 'theme-logo';
  }
  else {
    $vars['classes_array'][] = 'theme-logo-none';
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

  if (!$vars['is_front']) {
    // Add unique class for each page.
    $path = drupal_get_path_alias($_GET['q']);
    // Add unique class for each website section.
    list($section,) = explode('/', $path, 2);
    $arg = explode('/', $_GET['q']);
    if ($arg[0] == 'node' && isset($arg[1])) {
      if ($arg[1] == 'add') {
        $section = 'node-add';
      }
      elseif (isset($arg[2]) && is_numeric($arg[1]) && ($arg[2] == 'edit' || $arg[2] == 'delete')) {
        $section = 'node-' . $arg[2];
      }
    }
    $vars['classes_array'][] = drupal_html_class('section-' . $section);
  }

  // Add various classes for common site paths.
  if ($node = menu_get_object()) {
    $vars['classes_array'][] = 'is-node';
  }
  else {
    $vars['classes_array'][] = 'not-node';
  }

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
 * Implements hook_html_head_alter().
 */
function gratis_html_head_alter(&$head_elements) {

  global $base_url;
  // Get our current uri.
  $uri = drupal_get_path_alias();

  // We try to match it by forming the right key with the info we have.
  $key = 'drupal_add_html_head_link:canonical:</' . $uri . '>;';

  // Check that it is set, then we re-set it to the correct full url.
  if (isset($head_elements[$key])) {
    // Alter our head_element.
    $head_elements[$key]['#attributes']['href'] = $base_url . '/' . $uri;
  }

  // Simplify the meta charset declaration.
  $head_elements['system_meta_content_type']['#attributes'] = array(
    'charset' => 'utf-8',
  );
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

/**
 * Insert themed breadcrumb page navigation at top of the node content.
 */
function gratis_breadcrumb($vars) {
  // Show breadcrumbs if checked.
  if (theme_get_setting('breadcrumb') == 1) {
    // Theme the breadcrumbs.
    $breadcrumb = $vars['breadcrumb'];
    if (!empty($breadcrumb)) {
      // Use CSS to hide titile .element-invisible.
      $output = '<h2 class="element-invisible">' . t('You are here') . '</h2>';
      // Comment below line to hide current page to breadcrumb.
      $breadcrumb[] = drupal_get_title();
      $output .= '<nav class="breadcrumb">' . implode(' » ', $breadcrumb) . '</nav>';
      return $output;
    }
  }
}

/**
 * Override or insert variables into the page template.
 */
function gratis_preprocess_page(&$vars, $hook) {
  // If the default logo is used, then determine which color and set the path.
  $file = theme_get_setting('theme_color_palette');
  if (theme_get_setting('gratis_themelogo') == TRUE) {
    $vars['logo'] = base_path() . path_to_theme() . '/images/logo-' . $file . '.png';
  }

  // Check if it's a node and set a variable.
  $vars['is_node'] = FALSE;
  if ($node = menu_get_object()) {
    $vars['is_node'] = TRUE;
  }

  // Set the custom grid width in a variable.
  $gridwidth = theme_get_setting('gratis_grid_container_width');
  $vars['setwidth'] = $gridwidth;

  // Add information about the number of sidebars.
  // Both sidebars.
  if (!empty($vars['page']['sidebar_first']) && !empty($vars['page']['sidebar_second'])) {
    $vars['sb_columns'] = 'grid-20 pull-60';
    $vars['content_columns'] = 'grid-60 push-20';
  }
  // Sidebar first.
  elseif (!empty($vars['page']['sidebar_first'])) {
    $vars['sb_columns'] = 'grid-20 pull-80';
    $vars['content_columns'] = 'grid-80 push-20';
  }
  // Sidebar second.
  elseif (!empty($vars['page']['sidebar_second'])) {
    $vars['sb_columns'] = 'grid-20 sidebar';
    $vars['content_columns'] = 'grid-80';
  }
  // no sidebars
  else {
    $vars['sb_columns'] = 1;
    $vars['content_columns'] = 'grid-100';
  }

  // Primary nav.
  $vars['primary_nav'] = FALSE;
  if ($vars['main_menu']) {
    // Build links.
    $vars['primary_nav'] = menu_tree(variable_get('menu_main_links_source', 'main-menu'));
    // Provide default theme wrapper function.
    $vars['primary_nav']['#theme_wrappers'] = array('menu_tree__primary');
  }
}

/**
 * Theme wrapper function for the primary menu links.
 */
//function gratis_menu_tree__primary(&$vars) {
//  return '<ul class="toggle-menu" data-breakpoint="769">' . $vars['tree'] . '</ul>';
//}

/**
 * Implements hook_preprocess_node().
 *
 * Copied from Sam Richard's (Snugug) fabulous Aurora Base Theme.
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
  $vars['title_attributes_array']['class'][] = 'node__title';
  $vars['content_attributes_array']['class'][] = 'node__content';
  $vars['content']['links']['#attributes']['class'][] = 'node__links';
  // Change modifier classes to use BEM syntax.
  $vars['classes_array'] = preg_replace('/^node-' . $css_node_type . '$/', 'node--' . $css_node_type, $vars['classes_array']);
  $vars['classes_array'] = preg_replace('/^node-promoted$/', 'node--promoted', $vars['classes_array']);
  $vars['classes_array'] = preg_replace('/^node-sticky$/', 'node--sticky', $vars['classes_array']);
  // Add modifier classes for view mode.
  $vars['classes_array'][] = 'node--' . $css_view_mode;
  $vars['classes_array'][] = 'node--' . $css_node_type . '--' . $css_view_mode;

  // Show only the username in submitted, the date is handled by node.tpl.php.
  $vars['submitted'] = t('Submitted by !username', array('!username' => $vars['name']));

  // Set date variables using drupal's format_date function.
  $vars['thedate'] = format_date($node->created, "custom", "j");
  $vars['themonth'] = format_date($node->created, "custom", "M");
  $vars['theyear'] = format_date($node->created, "custom", "Y");

}

/**
 * Implements hook_page_alter().
 */
function gratis_page_alter($page) {

  // Look in each visible region for blocks.
  foreach (system_region_list($GLOBALS['theme'], REGIONS_VISIBLE) as $region => $name) {
    if (!empty($page[$region])) {
      // Find the last block in the region.
      $blocks = array_reverse(element_children($page[$region]));
      while ($blocks && !isset($page[$region][$blocks[0]]['#block'])) {
        array_shift($blocks);
      }
      if ($blocks) {
        $page[$region][$blocks[0]]['#block']->last_in_region = TRUE;
      }
    }
  }

  if (theme_get_setting('gratis_viewport') == FALSE) {

    // No pinch and zoom.
    $viewport = array(
      '#type' => 'html_tag',
      '#tag' => 'meta',
      '#attributes' => array(
        'name' => 'viewport',
        'content' => 'width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no',
      ),
    );
    drupal_add_html_head($viewport, 'viewport');
  }

  else {
    // Pinch and Zoom enabled.
    $viewport = array(
      '#type' => 'html_tag',
      '#tag' => 'meta',
      '#attributes' => array(
        'name' => 'viewport',
        'content' => 'width=device-width, initial-scale=1.0, maximum-scale=2.0, minimum-scale=0.55, user-scalable=yes',
      ),
    );
    drupal_add_html_head($viewport, 'viewport');
  }
}

/**
 * Alters the JavaScript/CSS library registry.
 */
function gratis_css_alter(&$css) {
  $path_system = drupal_get_path('module', 'system');
  $remove = array(
    $path_system . '/system.menus.css',
  );

  // Remove stylesheets which match our remove array.
  foreach ($css as $stylesheet => $options) {
    if (in_array($stylesheet, $remove)) {
      unset($css[$stylesheet]);
    }
  }
}

/**
 * Returns HTML for a menu link and submenu.
 */
function gratis_menu_link(array $vars) {
  $element = $vars['element'];
  $sub_menu = '';
  $name_id = strtolower(strip_tags($element['#title']));
  // Remove colons and anything past colons.
  // Preserve alphanumerics, everything else goes away.
  $pattern = '/[^a-z]+/ ';
  $name_id = preg_replace($pattern, '', $name_id);
  $element['#attributes']['class'][] = 'menu-' . $element['#original_link']['mlid'] . ' ' . $name_id;
  // Add levels.
  $element['#attributes']['class'][] = 'level-' . $element['#original_link']['depth'];

  if ($element['#below']) {
    $sub_menu = drupal_render($element['#below']);
  }

  $output = l($element['#title'], $element['#href'], $element['#localized_options']);
  return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";
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



