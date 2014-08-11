<?php

/**
 * @file
 * Gratis custom alter functions.
 *
 * If you need to add or modify functions do it in your sub-theme.
 */

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
 * Implements hook_page_alter().
 */
function gratis_page_alter($page) {

  // Define the module path for use below.
  $theme_path = drupal_get_path('theme', 'gratis');

  // Add general JS, weight last.
  $gratis_js = array(
    '#attached' => array(
      'js' => array(
        $theme_path . '/js/gratis.js' => array(
          'group' => JS_THEME,
          'preprocess' => TRUE,
          'weight' => 999,
        ),
      ),
    ),
  );
  drupal_render($gratis_js);

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