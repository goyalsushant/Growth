<?php

namespace Drupal\custom_contact_data\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\block_content\Entity\BlockContent;


/**
 * Class Display.
 *
 * @package Drupal\custom_contact_data\Controller
 */
class ReportController extends ControllerBase {

  /**
   * Showdata.
   *
   * @return string
   *   Return TabDisplayle format data.
   */
  public function report() {
    $block = BlockContent::load(1);

    $block_view = \Drupal::entityTypeManager()->getViewBuilder('block_content')->view($block);
    $block_view = $block_view['#block_content']->getTranslation('hi');
    kint($block_view->info->getValue());
    die;
    $result = \Drupal::database()->select('custom_contact_data', 'n')
      ->fields('n', ['id', 'name', 'mail', 'contact', 'city', 'address', 'gender'])
      ->execute()->fetchAllAssoc('id');
    $rows = [];
    foreach ($result as $row => $content) {
      $rows[] = [
        'data' => [$content->id, $content->name, $content->mail, $content->contact,
          $content->city, $content->address, $content->gender,
        ],
      ];
    }
    $header = ['id', 'name', 'mail', 'contact', 'city', 'address', 'gender'];
    // Here you can write #type also instead of #theme.
    $output = [
      '#theme' => 'table',
      '#header' => $header,
      '#rows' => $rows,
    ];
    return $output;
  }

}
