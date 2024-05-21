# Silverstripe CryptoProtect

CryptoProtect is a Proof of Work Captcha Form extension for Silverstripe's [SpamProtection Module](https://github.com/silverstripe/silverstripe-spamprotection).

The Proof of Work mechanism leverages SHA256 hashing to use the computational power of the client's device, significantly deterring Spam-Bots from flooding forms.

Working demo on [iloveunix.com/contact-us](https://iloveunix.com/contact-us).


## Requirements

* Silverstripe CMS version 4 or 5
* Silverstripe SpamProtection Module version 3 or higher


## Installation

Install using Composer:
```sh
composer require minimalic/silverstripe-cryptoprotect
```


## Configuration

### 1. Set default protector

Set CryptoProtect as the default captcha in your project's config (e.g. `spamprotection.yml`):
```yaml
SilverStripe\SpamProtection\Extension\FormSpamProtectionExtension:
  default_spam_protector: minimalic\CryptoProtect\Forms\CryptographicChallengeProtector
```

### 2. Rebuild Database

Refresh your database by navigating to your website's root directory in the shell and running:<br>
`vendor/bin/sake dev/build "flush=all"`

Or use your base URL with:<br>
`/dev/build?flush=all`

### 3. Generate hashes

In the CMS, navigate to the "admin/cryptographic-challenges" area and generate new hashes.

### 4. Add field

Add new "Spam Protection Field" to your Form.


## Customization

### The YAML file

Fine-tune the hashing mechanism in your project's config (e.g. `spamprotection.yml`). The currently available options with default values:
```yaml
minimalic\CryptoProtect\Models\CryptographicChallenge:
  difficulty_cycles: 100000
  hashes_count: 20
  hide_input_by: 'bootstrap'
  show_calculation_status: true
  show_progress_bar: true
  hide_after_solving: true
```
Note: Increasing `difficulty_cycles` may extend calculation times on slower devices (client-side).
A higher `hashes_count` requires more time for hash regeneration (server-side).

### Display options

`hide_input_by` - Hide input field by using one of available options:
 * `bootstrap` default, use the "visually-hidden" class
 * `style` use a "display: none" inline style
 * `none` show the input field

> [!NOTE]
> The hash input field is always shown in browsers with disabled JS as fallback to be able to resolve the challenge by hand.

`show_calculation_status` - Display a loading spinner/complete checkmark and status text

`show_progress_bar` - Display a progress bar

`hide_after_solving` - Hide the spinner/status and/or the progress bar after 4 seconds

### Finish customization

Remember to flush your caches (`?flush=all`) and regenerate hashes in the CMS whenever adjusting the configuration.

For more detailed information on configuring and utilizing the Spam Protection Field, visit the [SpamProtection Module](https://github.com/silverstripe/silverstripe-spamprotection) repository.


## License

See [License](LICENSE)

Copyright (c) 2024, minimalic.com - Sebastian Finke
All rights reserved.

