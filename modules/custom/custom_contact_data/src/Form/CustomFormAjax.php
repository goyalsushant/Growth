<?php

namespace Drupal\custom_contact_data\Form;

use Drupal\user\Entity\User;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Our simple form class.
 */
class CustomFormAjax extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'drupalup_simple_ajax_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $node = \Drupal::routeMatch()->getParameter('node');
    $nid = $node->value;
    $form['name'] = [
      '#title' => t('Name'),
      '#type' => 'textfield',
      '#size' => 25,
      '#description' => t("Name"),
      '#required' => TRUE,
    ];
    $form['gender'] = [
      '#title' => t('Gender'),
      '#type' => 'radios',
      '#size' => 25,
      '#description' => t("Gender"),
      '#options' => ['male' => t('male'), 'female' => t('female')],
    ];
    $form['contact'] = [
      '#title' => t('Contact'),
      '#type' => 'number',
      '#size' => 10,
      '#description' => t("Contact"),
      '#required' => TRUE,
    ];
    $form['email'] = [
      '#title' => t('Email Address'),
      '#type' => 'textfield',
      '#size' => 25,
      '#description' => t("Email address"),
      '#required' => TRUE,
    ];
    $form['description'] = [
      '#title' => t('Description'),
      '#type' => 'textfield',
      '#size' => 25,
      '#description' => t("Description"),
      '#required' => TRUE,
    ];
    $form['city'] = [
      '#title' => t('City'),
      '#type' => 'textfield',
      '#size' => 25,
      '#description' => t("City"),
      '#required' => TRUE,
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => t('submit'),
      '#ajax' => [
        'callback' => '::setMessage',
      ],
    ];
    $form['nid'] = [
      '#type' => 'hidden',
      '#value' => $nid,
    ];
    // $form['actions'] = [
    // '#type' => 'submit',
    // '#value' => $this->t('submit'),
    // '#ajax' => [
    // 'callback' => '::setMessage',
    // ]
    // ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $user = User::load(\Drupal::currentUser()->id());
    $database = \Drupal::service('database');
    $database->insert('custom_contact_data')->fields([
      'name' => $form_state->getValue('name'),
      'gender' => $form_state->getValue('gender'),
      'contact' => $form_state->getValue('contact'),
      'mail' => $form_state->getValue('email'),
      'description' => $form_state->getValue('description'),
      'city' => $form_state->getValue('city'),
      'nid' => $form_state->getValue('nid'),
      'uid' => $user->id(),
      'created' => time(),
    ])->execute();
    drupal_set_message(t('Data inserted successfully'));
  }

}
