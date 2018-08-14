<?php

namespace Drupal\kino_status\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class StatusEntityTypeForm.
 */
class StatusEntityTypeForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $status_entity_type = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $status_entity_type->label(),
      '#description' => $this->t("Label for the Status entity type."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $status_entity_type->id(),
      '#machine_name' => [
        'exists' => '\Drupal\kino_status\Entity\StatusEntityType::load',
      ],
      '#disabled' => !$status_entity_type->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $status_entity_type = $this->entity;
    $status = $status_entity_type->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Status entity type.', [
          '%label' => $status_entity_type->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Status entity type.', [
          '%label' => $status_entity_type->label(),
        ]));
    }
    $form_state->setRedirectUrl($status_entity_type->toUrl('collection'));
  }

}
