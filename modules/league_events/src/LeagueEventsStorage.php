<?php

namespace Drupal\league_events;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
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
class LeagueEventsStorage extends SqlContentEntityStorage implements LeagueEventsStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(LeagueEventsInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM {league_events_revision} WHERE id=:id ORDER BY vid',
      array(':id' => $entity->id())
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM {league_events_field_revision} WHERE uid = :uid ORDER BY vid',
      array(':uid' => $account->id())
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function countDefaultLanguageRevisions(LeagueEventsInterface $entity) {
    return $this->database->query('SELECT COUNT(*) FROM {league_events_field_revision} WHERE id = :id AND default_langcode = 1', array(':id' => $entity->id()))
      ->fetchField();
  }

  /**
   * {@inheritdoc}
   */
  public function clearRevisionsLanguage(LanguageInterface $language) {
    return $this->database->update('league_events_revision')
      ->fields(array('langcode' => LanguageInterface::LANGCODE_NOT_SPECIFIED))
      ->condition('langcode', $language->getId())
      ->execute();
  }

}
