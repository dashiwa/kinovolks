<?php

namespace Drupal\kino_entity;

use Drupal\Core\Entity\ContentEntityStorageInterface;
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
interface KinoEntityStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Kino entity revision IDs for a specific Kino entity.
   *
   * @param \Drupal\kino_entity\Entity\KinoEntityInterface $entity
   *   The Kino entity entity.
   *
   * @return int[]
   *   Kino entity revision IDs (in ascending order).
   */
  public function revisionIds(KinoEntityInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Kino entity author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Kino entity revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\kino_entity\Entity\KinoEntityInterface $entity
   *   The Kino entity entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(KinoEntityInterface $entity);

  /**
   * Unsets the language for all Kino entity with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
