<?php

namespace Drupal\kino_entity\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Kino entity type entity.
 *
 * @ConfigEntityType(
 *   id = "kino_entity_type",
 *   label = @Translation("Kino entity type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\kino_entity\KinoEntityTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\kino_entity\Form\KinoEntityTypeForm",
 *       "edit" = "Drupal\kino_entity\Form\KinoEntityTypeForm",
 *       "delete" = "Drupal\kino_entity\Form\KinoEntityTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\kino_entity\KinoEntityTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "kino_entity_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "kino_entity",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/kino_entity_type/{kino_entity_type}",
 *     "add-form" = "/admin/structure/kino_entity_type/add",
 *     "edit-form" =
 *   "/admin/structure/kino_entity_type/{kino_entity_type}/edit",
 *     "delete-form" =
 *   "/admin/structure/kino_entity_type/{kino_entity_type}/delete",
 *     "collection" = "/admin/structure/kino_entity_type"
 *   }
 * )
 */
class KinoEntityType extends ConfigEntityBundleBase implements KinoEntityTypeInterface {

  /**
   * The Kino entity type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Kino entity type label.
   *
   * @var string
   */
  protected $label;

}
