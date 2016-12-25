<?php

/**
 * @file
 * Contains league_lineup.page.inc.
 *
 * Page callback for League lineup entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for League lineup templates.
 *
 * Default template: league_lineup.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_league_lineup(array &$variables) {
  // Fetch LeagueLineup Entity Object.
  $league_lineup = $variables['elements']['#league_lineup'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
