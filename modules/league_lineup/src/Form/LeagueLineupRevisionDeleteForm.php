<?php

namespace Drupal\league_lineup\Form;

use Drupal\Core\Database\Connection;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a form for deleting a League lineup revision.
 *
 * @ingroup league_lineup
 */
class LeagueLineupRevisionDeleteForm extends ConfirmFormBase {


  /**
   * The League lineup revision.
   *
   * @var \Drupal\league_lineup\Entity\LeagueLineupInterface
   */
  protected $revision;

  /**
   * The League lineup storage.
   *
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  protected $LeagueLineupStorage;

  /**
   * The database connection.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $connection;

  /**
   * Constructs a new LeagueLineupRevisionDeleteForm.
   *
   * @param \Drupal\Core\Entity\EntityStorageInterface $entity_storage
   *   The entity storage.
   * @param \Drupal\Core\Database\Connection $connection
   *   The database connection.
   */
  public function __construct(EntityStorageInterface $entity_storage, Connection $connection) {
    $this->LeagueLineupStorage = $entity_storage;
    $this->connection = $connection;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    $entity_manager = $container->get('entity.manager');
    return new static(
      $entity_manager->getStorage('league_lineup'),
      $container->get('database')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'league_lineup_revision_delete_confirm';
  }

  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    return t('Are you sure you want to delete the revision from %revision-date?', array('%revision-date' => format_date($this->revision->getRevisionCreationTime())));
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelUrl() {
    return new Url('entity.league_lineup.version_history', array('league_lineup' => $this->revision->id()));
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
  public function buildForm(array $form, FormStateInterface $form_state, $league_lineup_revision = NULL) {
    $this->revision = $this->LeagueLineupStorage->loadRevision($league_lineup_revision);
    $form = parent::buildForm($form, $form_state);

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->LeagueLineupStorage->deleteRevision($this->revision->getRevisionId());

    $this->logger('content')->notice('League lineup: deleted %title revision %revision.', array('%title' => $this->revision->label(), '%revision' => $this->revision->getRevisionId()));
    drupal_set_message(t('Revision from %revision-date of League lineup %title has been deleted.', array('%revision-date' => format_date($this->revision->getRevisionCreationTime()), '%title' => $this->revision->label())));
    $form_state->setRedirect(
      'entity.league_lineup.canonical',
       array('league_lineup' => $this->revision->id())
    );
    if ($this->connection->query('SELECT COUNT(DISTINCT vid) FROM {league_lineup_field_revision} WHERE id = :id', array(':id' => $this->revision->id()))->fetchField() > 1) {
      $form_state->setRedirect(
        'entity.league_lineup.version_history',
         array('league_lineup' => $this->revision->id())
      );
    }
  }

}
