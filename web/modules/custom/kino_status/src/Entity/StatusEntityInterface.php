<?php

namespace Drupal\kino_status\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Status entity entities.
 *
 * @ingroup kino_status
 */
interface StatusEntityInterface extends ContentEntityInterface, RevisionLogInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Status entity name.
   *
   * @return string
   *   Name of the Status entity.
   */
  public function getName();

  /**
   * Sets the Status entity name.
   *
   * @param string $name
   *   The Status entity name.
   *
   * @return \Drupal\kino_status\Entity\StatusEntityInterface
   *   The called Status entity entity.
   */
  public function setName($name);

  /**
   * Gets the Status entity creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Status entity.
   */
  public function getCreatedTime();

  /**
   * Sets the Status entity creation timestamp.
   *
   * @param int $timestamp
   *   The Status entity creation timestamp.
   *
   * @return \Drupal\kino_status\Entity\StatusEntityInterface
   *   The called Status entity entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Status entity published status indicator.
   *
   * Unpublished Status entity are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Status entity is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Status entity.
   *
   * @param bool $published
   *   TRUE to set this Status entity to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\kino_status\Entity\StatusEntityInterface
   *   The called Status entity entity.
   */
  public function setPublished($published);

  /**
   * Gets the Status entity revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Status entity revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\kino_status\Entity\StatusEntityInterface
   *   The called Status entity entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Status entity revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Status entity revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\kino_status\Entity\StatusEntityInterface
   *   The called Status entity entity.
   */
  public function setRevisionUserId($uid);

}
