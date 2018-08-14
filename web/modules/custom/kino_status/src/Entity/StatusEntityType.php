<?php

namespace Drupal\kino_status\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Status entity type entity.
 *
 * @ConfigEntityType(
 *   id = "status_entity_type",
 *   label = @Translation("Status entity type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\kino_status\StatusEntityTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\kino_status\Form\StatusEntityTypeForm",
 *       "edit" = "Drupal\kino_status\Form\StatusEntityTypeForm",
 *       "delete" = "Drupal\kino_status\Form\StatusEntityTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\kino_status\StatusEntityTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "status_entity_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "status_entity",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/status_entity_type/{status_entity_type}",
 *     "add-form" = "/admin/structure/status_entity_type/add",
 *     "edit-form" = "/admin/structure/status_entity_type/{status_entity_type}/edit",
 *     "delete-form" = "/admin/structure/status_entity_type/{status_entity_type}/delete",
 *     "collection" = "/admin/structure/status_entity_type"
 *   }
 * )
 */
class StatusEntityType extends ConfigEntityBundleBase implements StatusEntityTypeInterface {

  /**
   * The Status entity type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Status entity type label.
   *
   * @var string
   */
  protected $label;

}
