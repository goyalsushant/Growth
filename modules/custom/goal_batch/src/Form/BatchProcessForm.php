<?php

namespace Drupal\goal_batch\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class BatchProcessForm.
 */
class BatchProcessForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'goal_batch_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['number_to_execute'] = [
      '#type' => 'number',
      '#title' => $this->t('Number of times to run'),
      '#required' => TRUE,
      '#min' => 1,
    ];
    $form['actions'] = ['#type' => 'actions'];
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => t('Execute'),
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $number = $form_state->getValue('number_to_execute');
    $batch = [
      'init_message' => t('Executing a batch...'),
      'operations' => [
        [
          '_new_batch',
          [$number],
        ],
      ],
      'file' => drupal_get_path('module', 'goal_batch') . '/goal_batch.new_batch.inc',
    ];
    batch_set($batch);
  }

}
