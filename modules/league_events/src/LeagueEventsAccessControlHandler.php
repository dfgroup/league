<?php

namespace Drupal\league_events;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the League events entity.
 *
 * @see \Drupal\league_events\Entity\LeagueEvents.
 */
class LeagueEventsAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\league_events\Entity\LeagueEventsInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished league events entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published league events entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit league events entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete league events entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add league events entities');
  }

}
