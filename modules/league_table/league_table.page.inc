<?php

/**
 * @file
 * Contains league_table.page.inc.
 *
 * Page callback for League table entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for League table templates.
 *
 * Default template: league_table.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_league_table(array &$variables) {
  // Fetch LeagueTable Entity Object.
  $league_table = $variables['elements']['#league_table'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
