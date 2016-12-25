<?php

namespace Drupal\league_lineup;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the League lineup entity.
 *
 * @see \Drupal\league_lineup\Entity\LeagueLineup.
 */
class LeagueLineupAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\league_lineup\Entity\LeagueLineupInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished league lineup entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published league lineup entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit league lineup entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete league lineup entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add league lineup entities');
  }

}
