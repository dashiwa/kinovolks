<?php

namespace Drupal\kino_storage\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Kino user entity entities.
 *
 * @ingroup kino_storage
 */
interface KinoUserEntityInterface extends ContentEntityInterface, RevisionLogInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Kino user entity name.
   *
   * @return string
   *   Name of the Kino user entity.
   */
  public function getName();

  /**
   * Sets the Kino user entity name.
   *
   * @param string $name
   *   The Kino user entity name.
   *
   * @return \Drupal\kino_storage\Entity\KinoUserEntityInterface
   *   The called Kino user entity entity.
   */
  public function setName($name);

  /**
   * Gets the Kino user entity creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Kino user entity.
   */
  public function getCreatedTime();

  /**
   * Sets the Kino user entity creation timestamp.
   *
   * @param int $timestamp
   *   The Kino user entity creation timestamp.
   *
   * @return \Drupal\kino_storage\Entity\KinoUserEntityInterface
   *   The called Kino user entity entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Kino user entity published status indicator.
   *
   * Unpublished Kino user entity are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Kino user entity is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Kino user entity.
   *
   * @param bool $published
   *   TRUE to set this Kino user entity to published, FALSE to set it to
   *   unpublished.
   *
   * @return \Drupal\kino_storage\Entity\KinoUserEntityInterface
   *   The called Kino user entity entity.
   */
  public function setPublished($published);

  /**
   * Gets the Kino user entity revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Kino user entity revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\kino_storage\Entity\KinoUserEntityInterface
   *   The called Kino user entity entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Kino user entity revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Kino user entity revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\kino_storage\Entity\KinoUserEntityInterface
   *   The called Kino user entity entity.
   */
  public function setRevisionUserId($uid);

}
