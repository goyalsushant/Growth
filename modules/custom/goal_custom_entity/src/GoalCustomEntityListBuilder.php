<?php

namespace Drupal\goal_custom_entity;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Goal custom entity entities.
 *
 * @ingroup goal_custom_entity
 */
class GoalCustomEntityListBuilder extends EntityListBuilder {


  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Goal custom entity ID');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\goal_custom_entity\Entity\GoalCustomEntity */
    $row['id'] = $entity->id();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.goal_custom_entity.edit_form',
      ['goal_custom_entity' => $entity->id()]
    );
    return $row + parent::buildRow($entity);
  }

}
