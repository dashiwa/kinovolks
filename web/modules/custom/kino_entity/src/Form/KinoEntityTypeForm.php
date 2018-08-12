<?php

namespace Drupal\kino_entity\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class KinoEntityTypeForm.
 */
class KinoEntityTypeForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $kino_entity_type = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $kino_entity_type->label(),
      '#description' => $this->t("Label for the Kino entity type."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $kino_entity_type->id(),
      '#machine_name' => [
        'exists' => '\Drupal\kino_entity\Entity\KinoEntityType::load',
      ],
      '#disabled' => !$kino_entity_type->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $kino_entity_type = $this->entity;
    $status = $kino_entity_type->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Kino entity type.', [
          '%label' => $kino_entity_type->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Kino entity type.', [
          '%label' => $kino_entity_type->label(),
        ]));
    }
    $form_state->setRedirectUrl($kino_entity_type->toUrl('collection'));
  }

}
