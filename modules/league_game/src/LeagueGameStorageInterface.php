<?php

namespace Drupal\league_game;

use Drupal\Core\Entity\ContentEntityStorageInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\league_game\Entity\LeagueGameInterface;

/**
 * Defines the storage handler class for League game entities.
 *
 * This extends the base storage class, adding required special handling for
 * League game entities.
 *
 * @ingroup league_game
 */
interface LeagueGameStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of League game revision IDs for a specific League game.
   *
   * @param \Drupal\league_game\Entity\LeagueGameInterface $entity
   *   The League game entity.
   *
   * @return int[]
   *   League game revision IDs (in ascending order).
   */
  public function revisionIds(LeagueGameInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as League game author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   League game revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\league_game\Entity\LeagueGameInterface $entity
   *   The League game entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(LeagueGameInterface $entity);

  /**
   * Unsets the language for all League game with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
