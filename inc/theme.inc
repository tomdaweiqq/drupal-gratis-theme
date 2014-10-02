<?php

/**
 * @file
 * Custom theme functions and theme function overrides.
 *
 * If you need to add or modify theme functions do it in your sub-theme.
 */

/**
 * Returns HTML for a list or nested list of items.
 *
 * Override theme_item_list
 */
function gratis_item_list($variables) {
  global $theme_key;
  $theme_name = $theme_key;

  $items = $variables['items'];
  $title = $variables['title'];
  $type = $variables['type'];
  $attributes = $variables['attributes'];

  // If a class exists use it on the wrapper, for Drupal core this mainly applies
  // to the pager, so you get the wrapper class .item-list-pager
  if (isset($attributes['class'])) {
    $output = '<div class="item-list item-list-' . $attributes['class'][0] . '">';
  }
  else {
    $output = '<div class="item-list">';
  }

  if (isset($title) && $title !== '') {
    $output .= '<h3>' . $title . '</h3>';
  }

  if (!empty($items)) {
    $output .= "<$type" . drupal_attributes($attributes) . '>';
    $num_items = count($items);
    foreach ($items as $i => $item) {
      $attributes = array();
      $children = array();
      $data = '';
      if (is_array($item)) {
        foreach ($item as $key => $value) {
          if ($key == 'data') {
            $data = $value;
          }
          elseif ($key == 'children') {
            $children = $value;
          }
          else {
            $attributes[$key] = $value;
          }
        }
      }
      else {
        $data = $item;
      }

      if (count($children) > 0) {
        // Render nested list.
        $data .= theme_item_list(array('items' => $children, 'title' => NULL, 'type' => $type, 'attributes' => $attributes));
      }

      if ($i & 1) {
        $attributes['class'][] = 'odd';
      }
      else {
        $attributes['class'][] = 'even';
      }
      if ($i == 0) {
        $attributes['class'][] = 'first';
      }
      if ($i == $num_items - 1) {
        $attributes['class'][] = 'last';
      }

      $output .= '<li' . drupal_attributes($attributes) . '>' . $data . "</li>"; // no new line!
    }
    $output .= "</$type>";
  }
  $output .= '</div>';

  return $output;
}


/**
 * Returns HTML for a field.
 *
 * Custom field override for gratis.
 */
function gratis_field($variables) {
  $output = '';

  // Render the label, if it's not hidden.
  if (!$variables['label_hidden']) {
    $output .= '<h2 class="field-label"' . $variables['title_attributes'] . '>' . $variables['label'] . ':&nbsp;</h2>';
  }

  // Render the items.
  $output .= '<div class="field-items"' . $variables['content_attributes'] . '>';
  foreach ($variables['items'] as $delta => $item) {
    $classes = 'field-item ' . ($delta % 2 ? 'odd' : 'even');
    $output .= '<div class="' . $classes . '"' . $variables['item_attributes'][$delta] . '>' . drupal_render($item) . '</div>';
  }
  $output .= '</div>';

  // Render the top-level wrapper element.
  $output = "<div class=\"" . $variables['classes'] . '"' . $variables['attributes'] . '>' . $output . "</div>";

  return $output;
}

/**
 * Returns HTML for a taxonomy field.
 *
 * Output taxonomy term fields as unordered lists.
 */
function gratis_field__taxonomy_term_reference($variables) {
  $output = '';

  // Render the label, if it's not hidden.
  if (!$variables['label_hidden']) {
    $output .= '<h2 class="field-label"' . $variables['title_attributes'] . '>' . $variables['label'] . ':&nbsp;</h2>';
  }

  // Render the items.
  $output .= '<ul class="vocabulary-list"' . $variables['content_attributes'] . '>';
  foreach ($variables['items'] as $delta => $item) {
    $classes = 'field-item ' . ($delta % 2 ? 'odd' : 'even');
    $output .= '<li class="' . 'vocabulary-links ' . $classes . '"' . $variables['item_attributes'][$delta] . '>' . drupal_render($item) . '</li>';
  }

  $output .= '</ul>';

  // Render the top-level wrapper element.
 // $tag = $variables['tag'];
  $output = "<span class=\"" . 'vocabulary ' . $variables['classes'] . '"' . $variables['attributes'] . '>' . $output . "</span>";

  return $output;
}

/**
 * Insert themed breadcrumb page navigation at top of the node content.
 */
function gratis_breadcrumb($variables) {
  // Show breadcrumbs if checked.
  if (theme_get_setting('breadcrumb') == 1) {
    // Theme the breadcrumbs.
    $breadcrumb = $variables['breadcrumb'];
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
 * Returns HTML for a feed icon.
 *
 * Override the feed icon.
 */
function gratis_feed_icon($variables) {
  // Define the module path for use below.
  $theme_path = drupal_get_path('theme', 'gratis');
  $text = t('Subscribe to !feed-title', array('!feed-title' => $variables['title']));
  if ($image = theme('image', array('path' => $theme_path . '/images/feed.png', 'width' => 32, 'height' => 32, 'alt' => $text))) {
    return l($image, $variables['url'], array('html' => TRUE, 'attributes' => array('class' => array('feed-icon'), 'title' => $text)));
  }
}
