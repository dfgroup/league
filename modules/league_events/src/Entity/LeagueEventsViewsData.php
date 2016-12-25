<?php

namespace Drupal\league_events\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for League events entities.
 */
class LeagueEventsViewsData extends EntityViewsData {

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
