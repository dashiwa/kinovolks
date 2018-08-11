<?php

namespace Drupal\kino_storage;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Kino user entity entities.
 *
 * @ingroup kino_storage
 */
class KinoUserEntityListBuilder extends EntityListBuilder {


  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Kino user entity ID');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\kino_storage\Entity\KinoUserEntity */
    $row['id'] = $entity->id();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.kino_user_entity.edit_form',
      ['kino_user_entity' => $entity->id()]
    );
    return $row + parent::buildRow($entity);
  }

}
