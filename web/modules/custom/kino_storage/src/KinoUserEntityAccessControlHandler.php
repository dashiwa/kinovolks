<?php

namespace Drupal\kino_storage;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Kino user entity entity.
 *
 * @see \Drupal\kino_storage\Entity\KinoUserEntity.
 */
class KinoUserEntityAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\kino_storage\Entity\KinoUserEntityInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished kino user entity entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published kino user entity entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit kino user entity entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete kino user entity entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add kino user entity entities');
  }

}
