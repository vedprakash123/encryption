** Usage
    
	- [x] Module is used to Encrypt/Decrypt given String. It has configuration form where admin can set the Key.
	- [x] Visit '/demo/crypto' & Test the Encrypt/Decrypt for the Given string. Refer the `screenshot.png` for Testing
	
** Installation

	- [x] Module is depends on the PHP Defuse Library. See composer.json for for more details.
	- [x] Use Composer to download the dependencies
		  composer require drupal/encryption
	
** Configuration

  - [x] Enter in to Drupal Root directory & run the `vendor/bin/generate-defuse-key`
  - [x] Visit `/admin/config/key/settings` & Enter the Key which has generated from the previous step.


** References

  - [Creating custom modules](https://www.drupal.org/docs/8/creating-custom-modules)
  - [DI] (https://www.drupal.org/docs/8/api/services-and-dependency-injection/services-and-dependency-injection-in-drupal-8)
  - [Drupal coding standards](https://www.drupal.org/node/318)