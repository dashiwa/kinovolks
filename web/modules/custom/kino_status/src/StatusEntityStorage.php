<?php

namespace Drupal\kino_status;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\kino_status\Entity\StatusEntityInterface;

/**
 * Defines the storage handler class for Status entity entities.
 *
 * This extends the base storage class, adding required special handling for
 * Status entity entities.
 *
 * @ingroup kino_status
 */
class StatusEntityStorage extends SqlContentEntityStorage implements StatusEntityStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(StatusEntityInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM {status_entity_revision} WHERE id=:id ORDER BY vid',
      [':id' => $entity->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM {status_entity_field_revision} WHERE uid = :uid ORDER BY vid',
      [':uid' => $account->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function countDefaultLanguageRevisions(StatusEntityInterface $entity) {
    return $this->database->query('SELECT COUNT(*) FROM {status_entity_field_revision} WHERE id = :id AND default_langcode = 1', [':id' => $entity->id()])
      ->fetchField();
  }

  /**
   * {@inheritdoc}
   */
  public function clearRevisionsLanguage(LanguageInterface $language) {
    return $this->database->update('status_entity_revision')
      ->fields(['langcode' => LanguageInterface::LANGCODE_NOT_SPECIFIED])
      ->condition('langcode', $language->getId())
      ->execute();
  }

}
