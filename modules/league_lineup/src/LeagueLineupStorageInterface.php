<?php

namespace Drupal\league_lineup;

use Drupal\Core\Entity\ContentEntityStorageInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\league_lineup\Entity\LeagueLineupInterface;

/**
 * Defines the storage handler class for League lineup entities.
 *
 * This extends the base storage class, adding required special handling for
 * League lineup entities.
 *
 * @ingroup league_lineup
 */
interface LeagueLineupStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of League lineup revision IDs for a specific League lineup.
   *
   * @param \Drupal\league_lineup\Entity\LeagueLineupInterface $entity
   *   The League lineup entity.
   *
   * @return int[]
   *   League lineup revision IDs (in ascending order).
   */
  public function revisionIds(LeagueLineupInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as League lineup author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   League lineup revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\league_lineup\Entity\LeagueLineupInterface $entity
   *   The League lineup entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(LeagueLineupInterface $entity);

  /**
   * Unsets the language for all League lineup with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
