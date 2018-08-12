<?php

namespace Drupal\kino_entity;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Kino entity entity.
 *
 * @see \Drupal\kino_entity\Entity\KinoEntity.
 */
class KinoEntityAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\kino_entity\Entity\KinoEntityInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished kino entity entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published kino entity entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit kino entity entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete kino entity entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add kino entity entities');
  }

}
