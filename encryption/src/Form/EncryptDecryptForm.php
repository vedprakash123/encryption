<?php

/**
 * @file
 * Contains \Drupal\encryption\Form\EncryptDecryptForm.
 */
namespace Drupal\encryption\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\State\StateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\encryption\Services\DataEncryptionService;

/**
 * Class EncryptDecryptForm.
 *
 * @package Drupal\encryption\Form
 */
class EncryptDecryptForm extends FormBase {

  /**
   * The Dncrypt/Decrypt Key.
   *
   * @var \Drupal\encryption\Services\DataEncryptionService
   */
  protected $crypto;

  /**
   * Constructs State, CelcomStore object.
   *
   * @param \Drupal\encryption\Services\DataEncryptionService $crypto
   *   Encrypt/Decrypt service.
   *
   */
  public function __construct(DataEncryptionService $crypto) {
    $this->crypto = $crypto;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
        $container->get('encryption.encryption')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'encrypt_decrypt_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form = [];
	
	$form['encryption'] = [
      '#type' => 'details',
      '#title' => $this->t('Encryption'),
      '#open' => TRUE,
    ];
	
	$form['encryption']['encryption_key'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Encryption Key'),
      '#size' => 128,
      '#description' => $this->t('Enter the String to be Encrypted.'),
    ];
	
	$form['encryption']['submit'] = [
      '#type' => 'button',
	  '#ajax' => [
		'callback' => '::encryptCallback',
		'event' => 'click',
		'wrapper' => 'edit-encrypt',
		'progress' => [
		  'type' => 'throbber',
		  'message' => $this->t('Processing...'),
		],
	  ],
      '#value' => $this->t('Encrypt'),
    ]; 
	
	$form['encryption']['encrypt'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Encrypted Value'),
      '#disabled' => TRUE,
	  '#prefix' => '<div id="edit-encrypt">',
      '#suffix' => '</div>',
    ];
	
	$form['decryption'] = [
      '#type' => 'details',
      '#title' => $this->t('Decryption'),
      '#open' => TRUE,
    ];
	
	$form['decryption']['decrypt_key'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Decryption Key'),
      '#description' => $this->t('Enter the String to be Decrypted.'),
    ];
	
	$form['decryption']['submit'] = [
      '#type' => 'button',
	  '#ajax' => [
		'callback' => '::decryptCallback',
		'event' => 'click',
		'wrapper' => 'edit-decrypt',
		'progress' => [
		  'type' => 'throbber',
		  'message' => $this->t('Processing...'),
		],
	  ],
      '#value' => $this->t('Decrypt'),
    ]; 
	
	$form['decryption']['decrypt'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Decrypted Value'),
      '#disabled' => TRUE,
	  '#size' => 128,
	  '#prefix' => '<div id="edit-decrypt">',
      '#suffix' => '</div>',
    ];
	
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    //parent::validateForm($form, $form_state);
  }

	/**
	 * An Ajax for encrypt Value.
	 */
	public function encryptCallback(array &$form, FormStateInterface $form_state) {
	  if ($selectedValue = $form_state->getValue('encryption_key')) {
		  $selectedText = $this->crypto->getEncryptedValue(trim($selectedValue));
		  $form['encryption']['encrypt']['#value'] = $selectedText;
	  }
	  return $form['encryption']['encrypt'];
	}

	/**
	 * An Ajax to decrypt Value.
	 */
	public function decryptCallback(array &$form, FormStateInterface $form_state) {
	  if ($selectedValue = $form_state->getValue('decrypt_key')) {
		  $selectedText = $this->crypto->getDecryptedValue(trim($selectedValue));
		  $form['decryption']['decrypt']['#value'] = $selectedText;
	  }
	  return $form['decryption']['decrypt'];
	}

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
	  // SubmitForm Values
  }

}
