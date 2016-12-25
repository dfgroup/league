<?php

namespace Drupal\league_table\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for League table entities.
 */
class LeagueTableViewsData extends EntityViewsData {

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
