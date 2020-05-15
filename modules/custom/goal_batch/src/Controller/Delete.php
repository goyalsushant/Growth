<?php

namespace Drupal\module\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Initialize class.
 */
class Delete extends ControllerBase {

  /**
   * @return \Symfony\Component\HttpFoundation\RedirectResponse
   */
  public function delete() {
    $view_results = views_get_view_result('boring_articles', 'page_1');
    $operations = [];
    foreach ($view_results as $key => $value) {
      $operations[] = [
        [
          $this->batchFunction($value->_entity->id()),
          [],
        ],
      ];
    }
    $batch = [
      'title' => t('Deleting'),
      'operations' => $operations,
      'finished' => $this->finished_callback(),
    ];
    batch_set($batch);
  }

  /**
   *
   */
  public function batchFunction($id) {
    $video = Node::load($id);
    $video->delete();
  }

  /**
   *
   */
  public function finished_callback() {
    $path = '/';
    return new RedirectResponse($path);
  }

}
