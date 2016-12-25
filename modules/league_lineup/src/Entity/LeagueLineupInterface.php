<?php

namespace Drupal\league_lineup\Entity;

use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\RevisionableInterface;
use Drupal\Component\Utility\Xss;
use Drupal\Core\Url;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining League lineup entities.
 *
 * @ingroup league_lineup
 */
interface LeagueLineupInterface extends RevisionableInterface, RevisionLogInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the League lineup name.
   *
   * @return string
   *   Name of the League lineup.
   */
  public function getName();

  /**
   * Sets the League lineup name.
   *
   * @param string $name
   *   The League lineup name.
   *
   * @return \Drupal\league_lineup\Entity\LeagueLineupInterface
   *   The called League lineup entity.
   */
  public function setName($name);

  /**
   * Gets the League lineup creation timestamp.
   *
   * @return int
   *   Creation timestamp of the League lineup.
   */
  public function getCreatedTime();

  /**
   * Sets the League lineup creation timestamp.
   *
   * @param int $timestamp
   *   The League lineup creation timestamp.
   *
   * @return \Drupal\league_lineup\Entity\LeagueLineupInterface
   *   The called League lineup entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the League lineup published status indicator.
   *
   * Unpublished League lineup are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the League lineup is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a League lineup.
   *
   * @param bool $published
   *   TRUE to set this League lineup to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\league_lineup\Entity\LeagueLineupInterface
   *   The called League lineup entity.
   */
  public function setPublished($published);

  /**
   * Gets the League lineup revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the League lineup revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\league_lineup\Entity\LeagueLineupInterface
   *   The called League lineup entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the League lineup revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the League lineup revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\league_lineup\Entity\LeagueLineupInterface
   *   The called League lineup entity.
   */
  public function setRevisionUserId($uid);

}
