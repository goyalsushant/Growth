<?php

namespace Drupal\custom_contact_data\Form;

use Drupal\user\Entity\User;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Our simple form class.
 */
class CustomForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'drupalup_simple_form';
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
    $form['address'] = [
      '#title' => t('Address'),
      '#type' => 'textfield',
      '#size' => 25,
      '#description' => t("Address"),
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
    ];
    $form['nid'] = [
      '#type' => 'hidden',
      '#value' => $nid,
    ];
    return $form;
  }

  /**
   * (@inheritdoc)
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $value = $form_state->getValue('email');
    $val1 = $form_state->getValue('name');
    $val2 = $form_state->getValue('contact');
    if ($value == !\Drupal::service('email.validator')->isValid($value)) {
      $form_state->setErrorByName('email', t('The email address %mail is not valid.', ['%mail' => $value]));
    }
    if (!preg_match("/^[A-Z]/", $val1)) {
      $form_state->setErrorByName('field_name', t('Name must start with capital letter'));
    }
    if (!preg_match("/^[9678]{1}[0-9]{9}$/", $val2)) {
      $form_state->setErrorByName('field_contact', t('Contact must be of 10 digits'));
    }
  }

  /**
   * (@inheritdoc)
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $user = User::load(\Drupal::currentUser()->id());
    // \Drupal::database();
    $database = \Drupal::service('database');
    // db_insert('rsvplist')->fields(array(.
    $database->insert('custom_contact_data')->fields([
      'name' => $form_state->getValue('name'),
      'gender' => $form_state->getValue('gender'),
      'contact' => $form_state->getValue('contact'),
      'mail' => $form_state->getValue('email'),
      'address' => $form_state->getValue('address'),
      'city' => $form_state->getValue('city'),
      'nid' => $form_state->getValue('nid'),
      'uid' => $user->id(),
      'created' => time(),
    ])->execute();
    drupal_set_message(t('Data inserted successfully'));
  }

}
