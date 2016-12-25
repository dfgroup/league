<?php

namespace Drupal\league_lineup\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for League lineup entities.
 */
class LeagueLineupViewsData extends EntityViewsData {

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
