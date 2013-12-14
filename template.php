<?php
/**
 * @file
 * Template.php provides theme functions & overrides
 */

/**
 * Implements hook_preprocess_html().
 */
function gratis_preprocess_html(&$vars) {
  // Add an ie10 class if needed.
  $inline_script = <<<EOL
  <script>if (Function('/*@cc_on return document.documentMode===10@*/') ()) {
    document.documentElement.className+=' ie10';
  }</script>
EOL;
  $element = array(
    '#type' => 'markup',
    '#markup' => $inline_script,
  );

  drupal_add_html_head($element, 'javascript');

  $vars['html_attributes_array'] = array();
  $vars['body_attributes_array'] = array();

  // HTML element attributes.
  $vars['html_attributes_array']['lang'] = $vars['language']->language;
  $vars['html_attributes_array']['dir']  = $vars['language']->dir;

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
  drupal_add_css('//fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,700italic,400,600,700',array('type' => 'external'));

  // Add font awesome cdn.
  drupal_add_css('//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css',array('type' => 'external'));

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

  // Add IE 9 fixes style sheet.
  drupal_add_css(path_to_theme() . '/css/ie9-fixes.css',
    array(
      'group' => CSS_THEME,
      'browsers' =>
      array(
        'IE' => 'iE 9',
        '!IE' => FALSE),
      'preprocess' => FALSE));

  // Extra body classes for theme variables.
  // The Color Palette.
  $file = theme_get_setting('theme_color_palette');
  $vars['classes_array'][] = drupal_html_class('color-palette-' . $file);

  // Local css within theme folder if checked.
  if (theme_get_setting('gratis_localcss') == TRUE) {
    drupal_add_css(path_to_theme() . '/css/local.css',
      array(
        'group' => CSS_THEME,
        'media' => 'screen',
        'preprocess' => TRUE,
        'weight' => '9997',
      )
      );
  }

  // Custom css file path if checked and file exists.
  if (theme_get_setting('gratis_custom_css_location') == TRUE) {
    $path = theme_get_setting('gratis_custom_css_path');
    if (file_exists($path)) {
      drupal_add_css("$path",
        array(
          'group' => CSS_THEME,
          'preprocess' => TRUE,
          'weight' => 9998,
        )
        );
    }
  }


// Add general JS.
  drupal_add_js(drupal_get_path('theme', 'gratis') . '/js/scripts.js',
    array(
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

  if(arg(0) == 'node' && arg(2) == 'edit') {
    $vars['classes_array'][] = 'page-node-edit';
  }

  if(arg(0) == 'node' && arg(1) == 'add') {
    $vars['classes_array'][] = 'page-node-add';
  }

  if(arg(0) == 'node' && arg(2) === null) {
    $vars['classes_array'][] = 'page-node-view';
  }

  if(arg(0) == 'admin') {
    $vars['classes_array'][] = 'admin-page';
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
    $head_elements[$key]['#attributes']['href'] = $base_url . '/' .$uri;
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
  $vars['thegrid'] = $gridwidth;

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

  // Postscript columns ('$pos_columns').
  if (!empty($vars['page']['postscript_first']) && !empty($vars['page']['postscript_second']) && !empty($vars['page']['postscript_third'])) {
    $vars['pos_columns'] =  'grid-33 postscript';
  }
  elseif (!empty($vars['page']['postscript_first']) && !empty($vars['page']['postscript_second'])) {
    $vars['pos_columns'] = 'grid-50 postscript';
  }
  elseif (!empty($vars['page']['postscript_first']) && !empty($vars['page']['postscript_third'])) {
    $vars['pos_columns'] = 'grid-50 postscript';
  }
  elseif (!empty($vars['page']['postscript_second']) && !empty($vars['page']['postscript_third'])) {
    $vars['pos_columns'] = 'grid-50 postscript';
  }
  else {
    $vars['pos_columns'] =  'grid-100 postscript';
  }

  // Postscript columns ('$pre_columns').
  if (!empty($vars['page']['preface_first']) && !empty($vars['page']['preface_second']) && !empty($vars['page']['preface_third'])) {
    $vars['pre_columns'] =  'grid-33 preface';
  }
  elseif (!empty($vars['page']['preface_first']) && !empty($vars['page']['preface_second'])) {
    $vars['pre_columns'] = 'grid-50 preface';
  }
  elseif (!empty($vars['page']['preface_first']) && !empty($vars['page']['preface_third'])) {
    $vars['pre_columns'] = 'grid-50 preface';
  }
  elseif (!empty($vars['page']['preface_second']) && !empty($vars['page']['preface_third'])) {
    $vars['pre_columns'] = 'grid-50 preface';
  }
  else {
    $vars['pre_columns'] =  'grid-100 preface';
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
function gratis_menu_tree__primary(&$vars) {
  return '<ul class="toggle-menu" data-breakpoint="769">' . $vars['tree'] . '</ul>';
}

/**
 * Override or insert variables into the node template.
 */
function gratis_preprocess_node(&$vars, $hook) {
  // Global node.
  $node = $vars['node'];

  if ($vars['view_mode'] == 'full' && node_is_page($node)) {
    $vars['classes_array'][] = 'node-full';
  }

  if ($vars['view_mode'] == 'teaser' && node_is_page($node)) {
    $vars['classes_array'][] = 'node-teaser';
  }

  // Some nice expanded classes for Nodes.
  $vars['attributes_array']['role'][] = 'article';
  $vars['title_attributes_array']['class'][] = 'article-title';
  $vars['content_attributes_array']['class'][] = 'article-content';

  // Show only the username in submitted, the date is handled by node.tpl.php.
  $vars['submitted'] = t('Submitted by !username',
    array('!username' => $vars['name']));

  // Set date variables using drupal's format_date function.
  $vars['thedate'] = format_date($node->created, "custom", "j");
  $vars['themonth'] = format_date($node->created, "custom", "M");
  $vars['theyear'] = format_date($node->created, "custom", "Y");
}

/**
 * Implements hook_page_alter().
 */
function gratis_page_alter($page) {

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
