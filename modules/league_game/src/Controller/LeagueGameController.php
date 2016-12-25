<?php

namespace Drupal\league_game\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\league_game\Entity\LeagueGameInterface;

/**
 * Class LeagueGameController.
 *
 *  Returns responses for League game routes.
 *
 * @package Drupal\league_game\Controller
 */
class LeagueGameController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Displays a League game  revision.
   *
   * @param int $league_game_revision
   *   The League game  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($league_game_revision) {
    $league_game = $this->entityManager()->getStorage('league_game')->loadRevision($league_game_revision);
    $view_builder = $this->entityManager()->getViewBuilder('league_game');

    return $view_builder->view($league_game);
  }

  /**
   * Page title callback for a League game  revision.
   *
   * @param int $league_game_revision
   *   The League game  revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($league_game_revision) {
    $league_game = $this->entityManager()->getStorage('league_game')->loadRevision($league_game_revision);
    return $this->t('Revision of %title from %date', array('%title' => $league_game->label(), '%date' => format_date($league_game->getRevisionCreationTime())));
  }

  /**
   * Generates an overview table of older revisions of a League game .
   *
   * @param \Drupal\league_game\Entity\LeagueGameInterface $league_game
   *   A League game  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(LeagueGameInterface $league_game) {
    $account = $this->currentUser();
    $langcode = $league_game->language()->getId();
    $langname = $league_game->language()->getName();
    $languages = $league_game->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $league_game_storage = $this->entityManager()->getStorage('league_game');

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $league_game->label()]) : $this->t('Revisions for %title', ['%title' => $league_game->label()]);
    $header = array($this->t('Revision'), $this->t('Operations'));

    $revert_permission = (($account->hasPermission("revert all league game revisions") || $account->hasPermission('administer league game entities')));
    $delete_permission = (($account->hasPermission("delete all league game revisions") || $account->hasPermission('administer league game entities')));

    $rows = array();

    $vids = $league_game_storage->revisionIds($league_game);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\league_game\LeagueGameInterface $revision */
      $revision = $league_game_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = \Drupal::service('date.formatter')->format($revision->revision_timestamp->value, 'short');
        if ($vid != $league_game->getRevisionId()) {
          $link = $this->l($date, new Url('entity.league_game.revision', ['league_game' => $league_game->id(), 'league_game_revision' => $vid]));
        }
        else {
          $link = $league_game->link($date);
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
              Url::fromRoute('league_game.revision_revert_translation_confirm', ['league_game' => $league_game->id(), 'league_game_revision' => $vid, 'langcode' => $langcode]) :
              Url::fromRoute('league_game.revision_revert_confirm', ['league_game' => $league_game->id(), 'league_game_revision' => $vid]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('league_game.revision_delete_confirm', ['league_game' => $league_game->id(), 'league_game_revision' => $vid]),
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

    $build['league_game_revisions_table'] = array(
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    );

    return $build;
  }

}
