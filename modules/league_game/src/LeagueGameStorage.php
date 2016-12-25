<?php

namespace Drupal\league_game;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
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
class LeagueGameStorage extends SqlContentEntityStorage implements LeagueGameStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(LeagueGameInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM {league_game_revision} WHERE id=:id ORDER BY vid',
      array(':id' => $entity->id())
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM {league_game_field_revision} WHERE uid = :uid ORDER BY vid',
      array(':uid' => $account->id())
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function countDefaultLanguageRevisions(LeagueGameInterface $entity) {
    return $this->database->query('SELECT COUNT(*) FROM {league_game_field_revision} WHERE id = :id AND default_langcode = 1', array(':id' => $entity->id()))
      ->fetchField();
  }

  /**
   * {@inheritdoc}
   */
  public function clearRevisionsLanguage(LanguageInterface $language) {
    return $this->database->update('league_game_revision')
      ->fields(array('langcode' => LanguageInterface::LANGCODE_NOT_SPECIFIED))
      ->condition('langcode', $language->getId())
      ->execute();
  }

}
