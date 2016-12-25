<?php

namespace Drupal\league_game\Entity;

use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\RevisionableInterface;
use Drupal\Component\Utility\Xss;
use Drupal\Core\Url;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining League game entities.
 *
 * @ingroup league_game
 */
interface LeagueGameInterface extends RevisionableInterface, RevisionLogInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the League game name.
   *
   * @return string
   *   Name of the League game.
   */
  public function getName();

  /**
   * Sets the League game name.
   *
   * @param string $name
   *   The League game name.
   *
   * @return \Drupal\league_game\Entity\LeagueGameInterface
   *   The called League game entity.
   */
  public function setName($name);

  /**
   * Gets the League game creation timestamp.
   *
   * @return int
   *   Creation timestamp of the League game.
   */
  public function getCreatedTime();

  /**
   * Sets the League game creation timestamp.
   *
   * @param int $timestamp
   *   The League game creation timestamp.
   *
   * @return \Drupal\league_game\Entity\LeagueGameInterface
   *   The called League game entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the League game published status indicator.
   *
   * Unpublished League game are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the League game is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a League game.
   *
   * @param bool $published
   *   TRUE to set this League game to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\league_game\Entity\LeagueGameInterface
   *   The called League game entity.
   */
  public function setPublished($published);

  /**
   * Gets the League game revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the League game revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\league_game\Entity\LeagueGameInterface
   *   The called League game entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the League game revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the League game revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\league_game\Entity\LeagueGameInterface
   *   The called League game entity.
   */
  public function setRevisionUserId($uid);

}
