<?php

/**
 * @file
 * Contains goal_custom_entity.page.inc.
 *
 * Page callback for Goal custom entity entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Goal custom entity templates.
 *
 * Default template: goal_custom_entity.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_goal_custom_entity(array &$variables) {
  // Fetch GoalCustomEntity Entity Object.
  $goal_custom_entity = $variables['elements']['#goal_custom_entity'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
