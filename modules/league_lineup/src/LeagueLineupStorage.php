<?php

namespace Drupal\league_lineup;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
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
class LeagueLineupStorage extends SqlContentEntityStorage implements LeagueLineupStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(LeagueLineupInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM {league_lineup_revision} WHERE id=:id ORDER BY vid',
      array(':id' => $entity->id())
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM {league_lineup_field_revision} WHERE uid = :uid ORDER BY vid',
      array(':uid' => $account->id())
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function countDefaultLanguageRevisions(LeagueLineupInterface $entity) {
    return $this->database->query('SELECT COUNT(*) FROM {league_lineup_field_revision} WHERE id = :id AND default_langcode = 1', array(':id' => $entity->id()))
      ->fetchField();
  }

  /**
   * {@inheritdoc}
   */
  public function clearRevisionsLanguage(LanguageInterface $language) {
    return $this->database->update('league_lineup_revision')
      ->fields(array('langcode' => LanguageInterface::LANGCODE_NOT_SPECIFIED))
      ->condition('langcode', $language->getId())
      ->execute();
  }

}
