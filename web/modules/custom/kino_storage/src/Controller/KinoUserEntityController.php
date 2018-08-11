<?php

namespace Drupal\kino_storage\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\kino_storage\Entity\KinoUserEntityInterface;

/**
 * Class KinoUserEntityController.
 *
 *  Returns responses for Kino user entity routes.
 */
class KinoUserEntityController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Displays a Kino user entity  revision.
   *
   * @param int $kino_user_entity_revision
   *   The Kino user entity  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($kino_user_entity_revision) {
    $kino_user_entity = $this->entityManager()
      ->getStorage('kino_user_entity')
      ->loadRevision($kino_user_entity_revision);
    $view_builder = $this->entityManager()->getViewBuilder('kino_user_entity');

    return $view_builder->view($kino_user_entity);
  }

  /**
   * Page title callback for a Kino user entity  revision.
   *
   * @param int $kino_user_entity_revision
   *   The Kino user entity  revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($kino_user_entity_revision) {
    $kino_user_entity = $this->entityManager()
      ->getStorage('kino_user_entity')
      ->loadRevision($kino_user_entity_revision);
    return $this->t('Revision of %title from %date', [
      '%title' => $kino_user_entity->label(),
      '%date' => format_date($kino_user_entity->getRevisionCreationTime()),
    ]);
  }

  /**
   * Generates an overview table of older revisions of a Kino user entity .
   *
   * @param \Drupal\kino_storage\Entity\KinoUserEntityInterface $kino_user_entity
   *   A Kino user entity  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(KinoUserEntityInterface $kino_user_entity) {
    $account = $this->currentUser();
    $langcode = $kino_user_entity->language()->getId();
    $langname = $kino_user_entity->language()->getName();
    $languages = $kino_user_entity->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $kino_user_entity_storage = $this->entityManager()
      ->getStorage('kino_user_entity');

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', [
      '@langname' => $langname,
      '%title' => $kino_user_entity->label(),
    ]) : $this->t('Revisions for %title', ['%title' => $kino_user_entity->label()]);
    $header = [$this->t('Revision'), $this->t('Operations')];

    $revert_permission = (($account->hasPermission("revert all kino user entity revisions") || $account->hasPermission('administer kino user entity entities')));
    $delete_permission = (($account->hasPermission("delete all kino user entity revisions") || $account->hasPermission('administer kino user entity entities')));

    $rows = [];

    $vids = $kino_user_entity_storage->revisionIds($kino_user_entity);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\kino_storage\KinoUserEntityInterface $revision */
      $revision = $kino_user_entity_storage->loadRevision($vid);
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
        if ($vid != $kino_user_entity->getRevisionId()) {
          $link = $this->l($date, new Url('entity.kino_user_entity.revision', [
            'kino_user_entity' => $kino_user_entity->id(),
            'kino_user_entity_revision' => $vid,
          ]));
        }
        else {
          $link = $kino_user_entity->link($date);
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
                Url::fromRoute('entity.kino_user_entity.translation_revert', [
                  'kino_user_entity' => $kino_user_entity->id(),
                  'kino_user_entity_revision' => $vid,
                  'langcode' => $langcode,
                ]) :
                Url::fromRoute('entity.kino_user_entity.revision_revert', [
                  'kino_user_entity' => $kino_user_entity->id(),
                  'kino_user_entity_revision' => $vid,
                ]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.kino_user_entity.revision_delete', [
                'kino_user_entity' => $kino_user_entity->id(),
                'kino_user_entity_revision' => $vid,
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

    $build['kino_user_entity_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}
