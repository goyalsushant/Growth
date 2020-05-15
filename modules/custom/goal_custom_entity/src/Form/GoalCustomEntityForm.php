<?php

namespace Drupal\goal_custom_entity\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Form controller for Goal custom entity edit forms.
 *
 * @ingroup goal_custom_entity
 */
class GoalCustomEntityForm extends ContentEntityForm {

  /**
   * @var \Drupal\Core\Messenger\MessengerInterface
   */
  protected $messenger;

  /**
   * Class constructor.
   */
  public function __construct(MessengerInterface $messenger) {
    $this->messenger = $messenger;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    // Instantiates this form class.
    return new static(
      // Load the service required to construct this class.
      $container->get('messenger')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\goal_custom_entity\Entity\GoalCustomEntity */
    $form = parent::buildForm($form, $form_state);

    $entity = $this->entity;

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $entity = $this->entity;

    $status = parent::save($form, $form_state);

    switch ($status) {
      case SAVED_NEW:
        $this->messenger->addMessage($this->t('Created the %label Goal custom entity.', [
          '%label' => $entity->label(),
        ]));
        break;

      default:
        $this->messenger->addMessage($this->t('Saved the %label Goal custom entity.', [
          '%label' => $entity->label(),
        ]));
    }
    $form_state->setRedirect('entity.goal_custom_entity.canonical', ['goal_custom_entity' => $entity->id()]);
  }

}
