<?php

namespace Drupal\goal_custom_entity\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Goal custom entity entities.
 *
 * @ingroup goal_custom_entity
 */
interface GoalCustomEntityInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Goal custom entity name.
   *
   * @return string
   *   Name of the Goal custom entity.
   */
  public function getName();

  /**
   * Sets the Goal custom entity name.
   *
   * @param string $name
   *   The Goal custom entity name.
   *
   * @return \Drupal\goal_custom_entity\Entity\GoalCustomEntityInterface
   *   The called Goal custom entity entity.
   */
  public function setName($name);

  /**
   * Gets the Goal custom entity creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Goal custom entity.
   */
  public function getCreatedTime();

  /**
   * Sets the Goal custom entity creation timestamp.
   *
   * @param int $timestamp
   *   The Goal custom entity creation timestamp.
   *
   * @return \Drupal\goal_custom_entity\Entity\GoalCustomEntityInterface
   *   The called Goal custom entity entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Goal custom entity published status indicator.
   *
   * Unpublished Goal custom entity are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Goal custom entity is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Goal custom entity.
   *
   * @param bool $published
   *   TRUE to set this Goal custom entity to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\goal_custom_entity\Entity\GoalCustomEntityInterface
   *   The called Goal custom entity entity.
   */
  public function setPublished($published);

}
