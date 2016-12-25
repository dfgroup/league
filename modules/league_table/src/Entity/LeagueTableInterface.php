<?php

namespace Drupal\league_table\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining League table entities.
 *
 * @ingroup league_table
 */
interface LeagueTableInterface extends  ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the League table name.
   *
   * @return string
   *   Name of the League table.
   */
  public function getName();

  /**
   * Sets the League table name.
   *
   * @param string $name
   *   The League table name.
   *
   * @return \Drupal\league_table\Entity\LeagueTableInterface
   *   The called League table entity.
   */
  public function setName($name);

  /**
   * Gets the League table creation timestamp.
   *
   * @return int
   *   Creation timestamp of the League table.
   */
  public function getCreatedTime();

  /**
   * Sets the League table creation timestamp.
   *
   * @param int $timestamp
   *   The League table creation timestamp.
   *
   * @return \Drupal\league_table\Entity\LeagueTableInterface
   *   The called League table entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the League table published status indicator.
   *
   * Unpublished League table are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the League table is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a League table.
   *
   * @param bool $published
   *   TRUE to set this League table to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\league_table\Entity\LeagueTableInterface
   *   The called League table entity.
   */
  public function setPublished($published);

}
