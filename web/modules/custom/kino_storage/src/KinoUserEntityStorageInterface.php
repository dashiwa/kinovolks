<?php

namespace Drupal\kino_storage;

use Drupal\Core\Entity\ContentEntityStorageInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\kino_storage\Entity\KinoUserEntityInterface;

/**
 * Defines the storage handler class for Kino user entity entities.
 *
 * This extends the base storage class, adding required special handling for
 * Kino user entity entities.
 *
 * @ingroup kino_storage
 */
interface KinoUserEntityStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Kino user entity revision IDs for a specific Kino user
   * entity.
   *
   * @param \Drupal\kino_storage\Entity\KinoUserEntityInterface $entity
   *   The Kino user entity entity.
   *
   * @return int[]
   *   Kino user entity revision IDs (in ascending order).
   */
  public function revisionIds(KinoUserEntityInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Kino user entity author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Kino user entity revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\kino_storage\Entity\KinoUserEntityInterface $entity
   *   The Kino user entity entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(KinoUserEntityInterface $entity);

  /**
   * Unsets the language for all Kino user entity with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
