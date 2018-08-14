<?php

namespace Drupal\kino_status\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\kino_status\Entity\StatusEntityInterface;

/**
 * Class StatusEntityController.
 *
 *  Returns responses for Status entity routes.
 */
class StatusEntityController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Displays a Status entity  revision.
   *
   * @param int $status_entity_revision
   *   The Status entity  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($status_entity_revision) {
    $status_entity = $this->entityManager()->getStorage('status_entity')->loadRevision($status_entity_revision);
    $view_builder = $this->entityManager()->getViewBuilder('status_entity');

    return $view_builder->view($status_entity);
  }

  /**
   * Page title callback for a Status entity  revision.
   *
   * @param int $status_entity_revision
   *   The Status entity  revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($status_entity_revision) {
    $status_entity = $this->entityManager()->getStorage('status_entity')->loadRevision($status_entity_revision);
    return $this->t('Revision of %title from %date', ['%title' => $status_entity->label(), '%date' => format_date($status_entity->getRevisionCreationTime())]);
  }

  /**
   * Generates an overview table of older revisions of a Status entity .
   *
   * @param \Drupal\kino_status\Entity\StatusEntityInterface $status_entity
   *   A Status entity  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(StatusEntityInterface $status_entity) {
    $account = $this->currentUser();
    $langcode = $status_entity->language()->getId();
    $langname = $status_entity->language()->getName();
    $languages = $status_entity->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $status_entity_storage = $this->entityManager()->getStorage('status_entity');

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $status_entity->label()]) : $this->t('Revisions for %title', ['%title' => $status_entity->label()]);
    $header = [$this->t('Revision'), $this->t('Operations')];

    $revert_permission = (($account->hasPermission("revert all status entity revisions") || $account->hasPermission('administer status entity entities')));
    $delete_permission = (($account->hasPermission("delete all status entity revisions") || $account->hasPermission('administer status entity entities')));

    $rows = [];

    $vids = $status_entity_storage->revisionIds($status_entity);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\kino_status\StatusEntityInterface $revision */
      $revision = $status_entity_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = \Drupal::service('date.formatter')->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $status_entity->getRevisionId()) {
          $link = $this->l($date, new Url('entity.status_entity.revision', ['status_entity' => $status_entity->id(), 'status_entity_revision' => $vid]));
        }
        else {
          $link = $status_entity->link($date);
        }

        $row = [];
        $column = [
          'data' => [
            '#type' => 'inline_template',
            '#template' => '{% trans %}{{ date }} by {{ username }}{% endtrans %}{% if message %}<p class="revision-log">{{ message }}</p>{% endif %}',
            '#context' => [
              'date' => $link,
              'username' => \Drupal::service('renderer')->renderPlain($username),
              'message' => ['#markup' => $revision->getRevisionLogMessage(), '#allowed_tags' => Xss::getHtmlTagList()],
            ],
          ],
        ];
        $row[] = $column;

        if ($latest_revision) {
          $row[] = [
            'data' => [
              '#prefix' => '<em>',
              '#markup' => $this->t('Current revision'),
              '#suffix' => '</em>',
            ],
          ];
          foreach ($row as &$current) {
            $current['class'] = ['revision-current'];
          }
          $latest_revision = FALSE;
        }
        else {
          $links = [];
          if ($revert_permission) {
            $links['revert'] = [
              'title' => $this->t('Revert'),
              'url' => $has_translations ?
              Url::fromRoute('entity.status_entity.translation_revert', ['status_entity' => $status_entity->id(), 'status_entity_revision' => $vid, 'langcode' => $langcode]) :
              Url::fromRoute('entity.status_entity.revision_revert', ['status_entity' => $status_entity->id(), 'status_entity_revision' => $vid]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.status_entity.revision_delete', ['status_entity' => $status_entity->id(), 'status_entity_revision' => $vid]),
            ];
          }

          $row[] = [
            'data' => [
              '#type' => 'operations',
              '#links' => $links,
            ],
          ];
        }

        $rows[] = $row;
      }
    }

    $build['status_entity_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}
