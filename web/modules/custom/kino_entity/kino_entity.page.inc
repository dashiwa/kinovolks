<?php

/**
 * @file
 * Contains kino_entity.page.inc.
 *
 * Page callback for Kino entity entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Kino entity templates.
 *
 * Default template: kino_entity.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_kino_entity(array &$variables) {
  // Fetch KinoEntity Entity Object.
  $kino_entity = $variables['elements']['#kino_entity'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
