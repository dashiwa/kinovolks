<?php

namespace Drupal\kino_entity\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\kino_entity\Entity\KinoEntityInterface;

/**
 * Class KinoEntityController.
 *
 *  Returns responses for Kino entity routes.
 */
class KinoEntityController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Displays a Kino entity  revision.
   *
   * @param int $kino_entity_revision
   *   The Kino entity  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($kino_entity_revision) {
    $kino_entity = $this->entityManager()
      ->getStorage('kino_entity')
      ->loadRevision($kino_entity_revision);
    $view_builder = $this->entityManager()->getViewBuilder('kino_entity');

    return $view_builder->view($kino_entity);
  }

  /**
   * Page title callback for a Kino entity  revision.
   *
   * @param int $kino_entity_revision
   *   The Kino entity  revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($kino_entity_revision) {
    $kino_entity = $this->entityManager()
      ->getStorage('kino_entity')
      ->loadRevision($kino_entity_revision);
    return $this->t('Revision of %title from %date', [
      '%title' => $kino_entity->label(),
      '%date' => format_date($kino_entity->getRevisionCreationTime()),
    ]);
  }

  /**
   * Generates an overview table of older revisions of a Kino entity .
   *
   * @param \Drupal\kino_entity\Entity\KinoEntityInterface $kino_entity
   *   A Kino entity  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(KinoEntityInterface $kino_entity) {
    $account = $this->currentUser();
    $langcode = $kino_entity->language()->getId();
    $langname = $kino_entity->language()->getName();
    $languages = $kino_entity->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $kino_entity_storage = $this->entityManager()->getStorage('kino_entity');

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', [
      '@langname' => $langname,
      '%title' => $kino_entity->label(),
    ]) : $this->t('Revisions for %title', ['%title' => $kino_entity->label()]);
    $header = [$this->t('Revision'), $this->t('Operations')];

    $revert_permission = (($account->hasPermission("revert all kino entity revisions") || $account->hasPermission('administer kino entity entities')));
    $delete_permission = (($account->hasPermission("delete all kino entity revisions") || $account->hasPermission('administer kino entity entities')));

    $rows = [];

    $vids = $kino_entity_storage->revisionIds($kino_entity);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\kino_entity\KinoEntityInterface $revision */
      $revision = $kino_entity_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)
          ->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = \Drupal::service('date.formatter')
          ->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $kino_entity->getRevisionId()) {
          $link = $this->l($date, new Url('entity.kino_entity.revision', [
            'kino_entity' => $kino_entity->id(),
            'kino_entity_revision' => $vid,
          ]));
        }
        else {
          $link = $kino_entity->link($date);
        }

        $row = [];
        $column = [
          'data' => [
            '#type' => 'inline_template',
            '#template' => '{% trans %}{{ date }} by {{ username }}{% endtrans %}{% if message %}<p class="revision-log">{{ message }}</p>{% endif %}',
            '#context' => [
              'date' => $link,
              'username' => \Drupal::service('renderer')
                ->renderPlain($username),
              'message' => [
                '#markup' => $revision->getRevisionLogMessage(),
                '#allowed_tags' => Xss::getHtmlTagList(),
              ],
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
                Url::fromRoute('entity.kino_entity.translation_revert', [
                  'kino_entity' => $kino_entity->id(),
                  'kino_entity_revision' => $vid,
                  'langcode' => $langcode,
                ]) :
                Url::fromRoute('entity.kino_entity.revision_revert', [
                  'kino_entity' => $kino_entity->id(),
                  'kino_entity_revision' => $vid,
                ]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.kino_entity.revision_delete', [
                'kino_entity' => $kino_entity->id(),
                'kino_entity_revision' => $vid,
              ]),
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

    $build['kino_entity_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}
