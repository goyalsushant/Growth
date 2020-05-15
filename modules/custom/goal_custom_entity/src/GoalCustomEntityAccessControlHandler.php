<?php

namespace Drupal\goal_custom_entity;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Goal custom entity entity.
 *
 * @see \Drupal\goal_custom_entity\Entity\GoalCustomEntity.
 */
class GoalCustomEntityAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\goal_custom_entity\Entity\GoalCustomEntityInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished goal custom entity entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published goal custom entity entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit goal custom entity entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete goal custom entity entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add goal custom entity entities');
  }

}
