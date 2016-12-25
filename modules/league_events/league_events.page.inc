<?php

/**
 * @file
 * Contains league_events.page.inc.
 *
 * Page callback for League events entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for League events templates.
 *
 * Default template: league_events.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_league_events(array &$variables) {
  // Fetch LeagueEvents Entity Object.
  $league_events = $variables['elements']['#league_events'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
