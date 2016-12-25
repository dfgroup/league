<?php

namespace Drupal\league_events;

use Drupal\Core\Entity\ContentEntityStorageInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\league_events\Entity\LeagueEventsInterface;

/**
 * Defines the storage handler class for League events entities.
 *
 * This extends the base storage class, adding required special handling for
 * League events entities.
 *
 * @ingroup league_events
 */
interface LeagueEventsStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of League events revision IDs for a specific League events.
   *
   * @param \Drupal\league_events\Entity\LeagueEventsInterface $entity
   *   The League events entity.
   *
   * @return int[]
   *   League events revision IDs (in ascending order).
   */
  public function revisionIds(LeagueEventsInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as League events author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   League events revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\league_events\Entity\LeagueEventsInterface $entity
   *   The League events entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(LeagueEventsInterface $entity);

  /**
   * Unsets the language for all League events with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
