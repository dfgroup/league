<?php

namespace Drupal\league_lineup\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\league_lineup\Entity\LeagueLineupInterface;

/**
 * Class LeagueLineupController.
 *
 *  Returns responses for League lineup routes.
 *
 * @package Drupal\league_lineup\Controller
 */
class LeagueLineupController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Displays a League lineup  revision.
   *
   * @param int $league_lineup_revision
   *   The League lineup  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($league_lineup_revision) {
    $league_lineup = $this->entityManager()->getStorage('league_lineup')->loadRevision($league_lineup_revision);
    $view_builder = $this->entityManager()->getViewBuilder('league_lineup');

    return $view_builder->view($league_lineup);
  }

  /**
   * Page title callback for a League lineup  revision.
   *
   * @param int $league_lineup_revision
   *   The League lineup  revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($league_lineup_revision) {
    $league_lineup = $this->entityManager()->getStorage('league_lineup')->loadRevision($league_lineup_revision);
    return $this->t('Revision of %title from %date', array('%title' => $league_lineup->label(), '%date' => format_date($league_lineup->getRevisionCreationTime())));
  }

  /**
   * Generates an overview table of older revisions of a League lineup .
   *
   * @param \Drupal\league_lineup\Entity\LeagueLineupInterface $league_lineup
   *   A League lineup  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(LeagueLineupInterface $league_lineup) {
    $account = $this->currentUser();
    $langcode = $league_lineup->language()->getId();
    $langname = $league_lineup->language()->getName();
    $languages = $league_lineup->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $league_lineup_storage = $this->entityManager()->getStorage('league_lineup');

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $league_lineup->label()]) : $this->t('Revisions for %title', ['%title' => $league_lineup->label()]);
    $header = array($this->t('Revision'), $this->t('Operations'));

    $revert_permission = (($account->hasPermission("revert all league lineup revisions") || $account->hasPermission('administer league lineup entities')));
    $delete_permission = (($account->hasPermission("delete all league lineup revisions") || $account->hasPermission('administer league lineup entities')));

    $rows = array();

    $vids = $league_lineup_storage->revisionIds($league_lineup);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\league_lineup\LeagueLineupInterface $revision */
      $revision = $league_lineup_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = \Drupal::service('date.formatter')->format($revision->revision_timestamp->value, 'short');
        if ($vid != $league_lineup->getRevisionId()) {
          $link = $this->l($date, new Url('entity.league_lineup.revision', ['league_lineup' => $league_lineup->id(), 'league_lineup_revision' => $vid]));
        }
        else {
          $link = $league_lineup->link($date);
        }

        $row = [];
        $column = [
          'data' => [
            '#type' => 'inline_template',
            '#template' => '{% trans %}{{ date }} by {{ username }}{% endtrans %}{% if message %}<p class="revision-log">{{ message }}</p>{% endif %}',
            '#context' => [
              'date' => $link,
              'username' => \Drupal::service('renderer')->renderPlain($username),
              'message' => ['#markup' => $revision->revision_log_message->value, '#allowed_tags' => Xss::getHtmlTagList()],
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
              Url::fromRoute('league_lineup.revision_revert_translation_confirm', ['league_lineup' => $league_lineup->id(), 'league_lineup_revision' => $vid, 'langcode' => $langcode]) :
              Url::fromRoute('league_lineup.revision_revert_confirm', ['league_lineup' => $league_lineup->id(), 'league_lineup_revision' => $vid]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('league_lineup.revision_delete_confirm', ['league_lineup' => $league_lineup->id(), 'league_lineup_revision' => $vid]),
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

    $build['league_lineup_revisions_table'] = array(
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    );

    return $build;
  }

}
