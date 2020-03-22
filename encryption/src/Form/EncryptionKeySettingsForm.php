<?php

/**
 * @file
 * Contains \Drupal\encryption\Form\EncryptionKeySettingsForm.
 */
namespace Drupal\encryption\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\State\StateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class EncryptionKeySettingsForm.
 *
 * @package Drupal\mdvip_experion\Form
 */
class EncryptionKeySettingsForm extends ConfigFormBase {
	/**
   * The State variable.
   *
   * @var \Drupal\Core\State\StateInterface
   */
  protected $state;

  /**
   * Constructs Key/value object.
   *
   * @param \Drupal\Core\State\StateInterface $state
   *   State Service Object.
   */
    public function __construct(StateInterface $state) {
        $this->state = $state;
    }

    /**
     * {@inheritdoc}
     */
    public static function create(ContainerInterface $container) {
        return new static(
            $container->get('state')
        );
    }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'encryption_key.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'encryption_key_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $key = $this->state->get('encryption_key');
    $form['encryption'] = [
      '#type' => 'details',
      '#title' => $this->t('Encryption Key settings'),
      '#open' => TRUE,
    ];
    $form['encryption']['encryption_key'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Encryption Key'),
      '#required' => TRUE,
      '#default_value' => isset($key) ? $key : '',
      '#description' => $this->t('Enter the Encrption Key.'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    $this->state->set('encryption_key', trim($values['encryption_key']));
	parent::submitForm($form, $form_state);
  }

}
