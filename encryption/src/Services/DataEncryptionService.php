<?php

/**
 * @file
 * Contains \Drupal\encryption\Services\DataEncryptionService.
 */
namespace Drupal\encryption\Services;

use Drupal\Core\State\StateInterface;
use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;
use Drupal\Core\Logger\LoggerChannelFactory;
use Defuse\Crypto\Exception\WrongKeyOrModifiedCiphertextException;
/**
 * Class DataEncryptionService.
 *
 * @package Drupal\encryption
 */
class DataEncryptionService {
  
  /**
   * The State variable.
   *
   * @var \Drupal\Core\State\StateInterface
   */
  protected $state;
  
  /**
   * Logger Factory.
   *
   * @var \Drupal\Core\Logger\LoggerChannelFactory
   */
  protected $loggerFactory;

  /**
   * Constructs Service object.
   *
   * @param \Drupal\Core\State\StateInterface $state
   *   State Service Object.
   * @param \Drupal\Core\Logger\LoggerChannelFactory $logger_factory
   *   Logger Service.
   *
   */
  public function __construct(StateInterface $state, LoggerChannelFactory $logger_factory) {
	$this->state = $state;
	$this->loggerFactory = $logger_factory->get('encryption');
  }

	/**
     * Load Encryption Key
	 *
     * @return Key
     */
	public function loadEncryptionKeyFromConfig()
	{
		$keyAscii = $this->state->get('encryption_key');
		return Key::loadFromAsciiSafeString($keyAscii);
	}

	/**
	 * Get Encrypted Value
	 *
     * @param string $string
     *    String Contains the Original Value
     * 
     * @return string
     *    String Contains the Encrypted Value
	 *
     */
	public function getEncryptedValue($string)
	{
		try {
			$key = $this->loadEncryptionKeyFromConfig();
			return Crypto::encrypt($string, $key);
		} catch (WrongKeyOrModifiedCiphertextException $ex) {
			$this->loggerFactory->error($this->t('Encryption Not Working. Kindly check wather the key is correct.'));
		}
	}

	/**
	 * Get Decrypted Value
	 *
     * @param string $string
     *    String Contains the Encrypted Key
     * 
     * @return string
     *    String Contains the Encrypted Value
     */
	public function getDecryptedValue($string)
	{
		$key = $this->loadEncryptionKeyFromConfig();
		try {
			$secret_data = Crypto::decrypt($string, $key);
			return $secret_data;
		} catch (WrongKeyOrModifiedCiphertextException $ex) {
			$this->loggerFactory->error($this->t('Decryption Not Working. Kindly check wather the key is correct.'));
		}
		
	}

}
