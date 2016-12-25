<?php

namespace Drupal\league_table;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the League table entity.
 *
 * @see \Drupal\league_table\Entity\LeagueTable.
 */
class LeagueTableAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\league_table\Entity\LeagueTableInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished league table entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published league table entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit league table entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete league table entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add league table entities');
  }

}
