<?php

namespace Drupal\kino_entity\Form;

use Drupal\Core\Database\Connection;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a form for deleting a Kino entity revision.
 *
 * @ingroup kino_entity
 */
class KinoEntityRevisionDeleteForm extends ConfirmFormBase {


  /**
   * The Kino entity revision.
   *
   * @var \Drupal\kino_entity\Entity\KinoEntityInterface
   */
  protected $revision;

  /**
   * The Kino entity storage.
   *
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  protected $KinoEntityStorage;

  /**
   * The database connection.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $connection;

  /**
   * Constructs a new KinoEntityRevisionDeleteForm.
   *
   * @param \Drupal\Core\Entity\EntityStorageInterface $entity_storage
   *   The entity storage.
   * @param \Drupal\Core\Database\Connection $connection
   *   The database connection.
   */
  public function __construct(EntityStorageInterface $entity_storage, Connection $connection) {
    $this->KinoEntityStorage = $entity_storage;
    $this->connection = $connection;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    $entity_manager = $container->get('entity.manager');
    return new static(
      $entity_manager->getStorage('kino_entity'),
      $container->get('database')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'kino_entity_revision_delete_confirm';
  }

  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    return t('Are you sure you want to delete the revision from %revision-date?', ['%revision-date' => format_date($this->revision->getRevisionCreationTime())]);
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelUrl() {
    return new Url('entity.kino_entity.version_history', ['kino_entity' => $this->revision->id()]);
  }

  /**
   * {@inheritdoc}
   */
  public function getConfirmText() {
    return t('Delete');
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $kino_entity_revision = NULL) {
    $this->revision = $this->KinoEntityStorage->loadRevision($kino_entity_revision);
    $form = parent::buildForm($form, $form_state);

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->KinoEntityStorage->deleteRevision($this->revision->getRevisionId());

    $this->logger('content')
      ->notice('Kino entity: deleted %title revision %revision.', [
        '%title' => $this->revision->label(),
        '%revision' => $this->revision->getRevisionId(),
      ]);
    drupal_set_message(t('Revision from %revision-date of Kino entity %title has been deleted.', [
      '%revision-date' => format_date($this->revision->getRevisionCreationTime()),
      '%title' => $this->revision->label(),
    ]));
    $form_state->setRedirect(
      'entity.kino_entity.canonical',
      ['kino_entity' => $this->revision->id()]
    );
    if ($this->connection->query('SELECT COUNT(DISTINCT vid) FROM {kino_entity_field_revision} WHERE id = :id', [':id' => $this->revision->id()])
        ->fetchField() > 1) {
      $form_state->setRedirect(
        'entity.kino_entity.version_history',
        ['kino_entity' => $this->revision->id()]
      );
    }
  }

}