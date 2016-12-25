<?php

namespace Drupal\league_player\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;

/**
 * Defines the Position entity.
 *
 * @ConfigEntityType(
 *   id = "position",
 *   label = @Translation("Position"),
 *   handlers = {
 *     "list_builder" = "Drupal\league_player\PositionListBuilder",
 *     "form" = {
 *       "add" = "Drupal\league_player\Form\PositionForm",
 *       "edit" = "Drupal\league_player\Form\PositionForm",
 *       "delete" = "Drupal\league_player\Form\PositionDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\league_player\PositionHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "position",
 *   admin_permission = "administer site configuration",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/position/{position}",
 *     "add-form" = "/admin/structure/position/add",
 *     "edit-form" = "/admin/structure/position/{position}/edit",
 *     "delete-form" = "/admin/structure/position/{position}/delete",
 *     "collection" = "/admin/structure/position"
 *   }
 * )
 */
class Position extends ConfigEntityBase implements PositionInterface {

  /**
   * The Position ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Position label.
   *
   * @var string
   */
  protected $label;

}
