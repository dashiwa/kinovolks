<?php

namespace Drupal\kino_entity;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\kino_entity\Entity\KinoEntityInterface;

/**
 * Defines the storage handler class for Kino entity entities.
 *
 * This extends the base storage class, adding required special handling for
 * Kino entity entities.
 *
 * @ingroup kino_entity
 */
class KinoEntityStorage extends SqlContentEntityStorage implements KinoEntityStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(KinoEntityInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM {kino_entity_revision} WHERE id=:id ORDER BY vid',
      [':id' => $entity->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM {kino_entity_field_revision} WHERE uid = :uid ORDER BY vid',
      [':uid' => $account->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function countDefaultLanguageRevisions(KinoEntityInterface $entity) {
    return $this->database->query('SELECT COUNT(*) FROM {kino_entity_field_revision} WHERE id = :id AND default_langcode = 1', [':id' => $entity->id()])
      ->fetchField();
  }

  /**
   * {@inheritdoc}
   */
  public function clearRevisionsLanguage(LanguageInterface $language) {
    return $this->database->update('kino_entity_revision')
      ->fields(['langcode' => LanguageInterface::LANGCODE_NOT_SPECIFIED])
      ->condition('langcode', $language->getId())
      ->execute();
  }

}
