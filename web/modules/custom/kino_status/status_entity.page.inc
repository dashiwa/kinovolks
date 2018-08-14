<?php

/**
 * @file
 * Contains status_entity.page.inc.
 *
 * Page callback for Status entity entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Status entity templates.
 *
 * Default template: status_entity.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_status_entity(array &$variables) {
  // Fetch StatusEntity Entity Object.
  $status_entity = $variables['elements']['#status_entity'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
