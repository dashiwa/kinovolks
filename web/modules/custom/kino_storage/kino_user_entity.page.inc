<?php

/**
 * @file
 * Contains kino_user_entity.page.inc.
 *
 * Page callback for Kino user entity entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Kino user entity templates.
 *
 * Default template: kino_user_entity.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_kino_user_entity(array &$variables) {
  // Fetch KinoUserEntity Entity Object.
  $kino_user_entity = $variables['elements']['#kino_user_entity'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
