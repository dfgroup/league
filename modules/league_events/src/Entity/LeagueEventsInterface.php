<?php

namespace Drupal\league_events\Entity;

use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\RevisionableInterface;
use Drupal\Component\Utility\Xss;
use Drupal\Core\Url;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining League events entities.
 *
 * @ingroup league_events
 */
interface LeagueEventsInterface extends RevisionableInterface, RevisionLogInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the League events name.
   *
   * @return string
   *   Name of the League events.
   */
  public function getName();

  /**
   * Sets the League events name.
   *
   * @param string $name
   *   The League events name.
   *
   * @return \Drupal\league_events\Entity\LeagueEventsInterface
   *   The called League events entity.
   */
  public function setName($name);

  /**
   * Gets the League events creation timestamp.
   *
   * @return int
   *   Creation timestamp of the League events.
   */
  public function getCreatedTime();

  /**
   * Sets the League events creation timestamp.
   *
   * @param int $timestamp
   *   The League events creation timestamp.
   *
   * @return \Drupal\league_events\Entity\LeagueEventsInterface
   *   The called League events entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the League events published status indicator.
   *
   * Unpublished League events are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the League events is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a League events.
   *
   * @param bool $published
   *   TRUE to set this League events to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\league_events\Entity\LeagueEventsInterface
   *   The called League events entity.
   */
  public function setPublished($published);

  /**
   * Gets the League events revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the League events revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\league_events\Entity\LeagueEventsInterface
   *   The called League events entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the League events revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the League events revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\league_events\Entity\LeagueEventsInterface
   *   The called League events entity.
   */
  public function setRevisionUserId($uid);

}
