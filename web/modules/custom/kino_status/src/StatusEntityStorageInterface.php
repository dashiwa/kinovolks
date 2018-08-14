<?php

namespace Drupal\kino_status;

use Drupal\Core\Entity\ContentEntityStorageInterface;
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
interface StatusEntityStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Status entity revision IDs for a specific Status entity.
   *
   * @param \Drupal\kino_status\Entity\StatusEntityInterface $entity
   *   The Status entity entity.
   *
   * @return int[]
   *   Status entity revision IDs (in ascending order).
   */
  public function revisionIds(StatusEntityInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Status entity author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Status entity revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\kino_status\Entity\StatusEntityInterface $entity
   *   The Status entity entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(StatusEntityInterface $entity);

  /**
   * Unsets the language for all Status entity with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
