<?php

namespace Drupal\kino_status\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Status entity entities.
 */
class StatusEntityViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.

    return $data;
  }

}
