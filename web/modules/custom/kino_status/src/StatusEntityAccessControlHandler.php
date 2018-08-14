<?php

namespace Drupal\kino_status;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Status entity entity.
 *
 * @see \Drupal\kino_status\Entity\StatusEntity.
 */
class StatusEntityAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\kino_status\Entity\StatusEntityInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished status entity entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published status entity entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit status entity entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete status entity entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add status entity entities');
  }

}
