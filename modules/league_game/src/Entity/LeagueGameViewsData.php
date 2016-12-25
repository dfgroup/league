<?php

namespace Drupal\league_game\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for League game entities.
 */
class LeagueGameViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.

    return $data;
  }

}
