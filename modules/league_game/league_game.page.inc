<?php

/**
 * @file
 * Contains league_game.page.inc.
 *
 * Page callback for League game entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for League game templates.
 *
 * Default template: league_game.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_league_game(array &$variables) {
  // Fetch LeagueGame Entity Object.
  $league_game = $variables['elements']['#league_game'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
