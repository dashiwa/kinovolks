<?php

namespace Drupal\kino_entity\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Kino entity entities.
 *
 * @ingroup kino_entity
 */
interface KinoEntityInterface extends ContentEntityInterface, RevisionLogInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Kino entity name.
   *
   * @return string
   *   Name of the Kino entity.
   */
  public function getName();

  /**
   * Sets the Kino entity name.
   *
   * @param string $name
   *   The Kino entity name.
   *
   * @return \Drupal\kino_entity\Entity\KinoEntityInterface
   *   The called Kino entity entity.
   */
  public function setName($name);

  /**
   * Gets the Kino entity creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Kino entity.
   */
  public function getCreatedTime();

  /**
   * Sets the Kino entity creation timestamp.
   *
   * @param int $timestamp
   *   The Kino entity creation timestamp.
   *
   * @return \Drupal\kino_entity\Entity\KinoEntityInterface
   *   The called Kino entity entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Kino entity published status indicator.
   *
   * Unpublished Kino entity are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Kino entity is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Kino entity.
   *
   * @param bool $published
   *   TRUE to set this Kino entity to published, FALSE to set it to
   *   unpublished.
   *
   * @return \Drupal\kino_entity\Entity\KinoEntityInterface
   *   The called Kino entity entity.
   */
  public function setPublished($published);

  /**
   * Gets the Kino entity revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Kino entity revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\kino_entity\Entity\KinoEntityInterface
   *   The called Kino entity entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Kino entity revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Kino entity revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\kino_entity\Entity\KinoEntityInterface
   *   The called Kino entity entity.
   */
  public function setRevisionUserId($uid);

}
