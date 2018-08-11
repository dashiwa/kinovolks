<?php

namespace Drupal\kino_storage\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Kino user entity type entity.
 *
 * @ConfigEntityType(
 *   id = "kino_user_entity_type",
 *   label = @Translation("Kino user entity type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\kino_storage\KinoUserEntityTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\kino_storage\Form\KinoUserEntityTypeForm",
 *       "edit" = "Drupal\kino_storage\Form\KinoUserEntityTypeForm",
 *       "delete" = "Drupal\kino_storage\Form\KinoUserEntityTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\kino_storage\KinoUserEntityTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "kino_user_entity_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "kino_user_entity",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" =
 *   "/admin/structure/kino_user_entity_type/{kino_user_entity_type}",
 *     "add-form" = "/admin/structure/kino_user_entity_type/add",
 *     "edit-form" =
 *   "/admin/structure/kino_user_entity_type/{kino_user_entity_type}/edit",
 *     "delete-form" =
 *   "/admin/structure/kino_user_entity_type/{kino_user_entity_type}/delete",
 *     "collection" = "/admin/structure/kino_user_entity_type"
 *   }
 * )
 */
class KinoUserEntityType extends ConfigEntityBundleBase implements KinoUserEntityTypeInterface {

  /**
   * The Kino user entity type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Kino user entity type label.
   *
   * @var string
   */
  protected $label;

}
