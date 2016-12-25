<?php

namespace Drupal\league_events\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\league_events\Entity\LeagueEventsInterface;

/**
 * Class LeagueEventsController.
 *
 *  Returns responses for League events routes.
 *
 * @package Drupal\league_events\Controller
 */
class LeagueEventsController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Displays a League events  revision.
   *
   * @param int $league_events_revision
   *   The League events  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($league_events_revision) {
    $league_events = $this->entityManager()->getStorage('league_events')->loadRevision($league_events_revision);
    $view_builder = $this->entityManager()->getViewBuilder('league_events');

    return $view_builder->view($league_events);
  }

  /**
   * Page title callback for a League events  revision.
   *
   * @param int $league_events_revision
   *   The League events  revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($league_events_revision) {
    $league_events = $this->entityManager()->getStorage('league_events')->loadRevision($league_events_revision);
    return $this->t('Revision of %title from %date', array('%title' => $league_events->label(), '%date' => format_date($league_events->getRevisionCreationTime())));
  }

  /**
   * Generates an overview table of older revisions of a League events .
   *
   * @param \Drupal\league_events\Entity\LeagueEventsInterface $league_events
   *   A League events  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(LeagueEventsInterface $league_events) {
    $account = $this->currentUser();
    $langcode = $league_events->language()->getId();
    $langname = $league_events->language()->getName();
    $languages = $league_events->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $league_events_storage = $this->entityManager()->getStorage('league_events');

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $league_events->label()]) : $this->t('Revisions for %title', ['%title' => $league_events->label()]);
    $header = array($this->t('Revision'), $this->t('Operations'));

    $revert_permission = (($account->hasPermission("revert all league events revisions") || $account->hasPermission('administer league events entities')));
    $delete_permission = (($account->hasPermission("delete all league events revisions") || $account->hasPermission('administer league events entities')));

    $rows = array();

    $vids = $league_events_storage->revisionIds($league_events);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\league_events\LeagueEventsInterface $revision */
      $revision = $league_events_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = \Drupal::service('date.formatter')->format($revision->revision_timestamp->value, 'short');
        if ($vid != $league_events->getRevisionId()) {
          $link = $this->l($date, new Url('entity.league_events.revision', ['league_events' => $league_events->id(), 'league_events_revision' => $vid]));
        }
        else {
          $link = $league_events->link($date);
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
              Url::fromRoute('league_events.revision_revert_translation_confirm', ['league_events' => $league_events->id(), 'league_events_revision' => $vid, 'langcode' => $langcode]) :
              Url::fromRoute('league_events.revision_revert_confirm', ['league_events' => $league_events->id(), 'league_events_revision' => $vid]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('league_events.revision_delete_confirm', ['league_events' => $league_events->id(), 'league_events_revision' => $vid]),
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

    $build['league_events_revisions_table'] = array(
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    );

    return $build;
  }

}
