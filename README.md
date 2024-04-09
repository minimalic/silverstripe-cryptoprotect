# Silverstripe CryptoProtect

Proof of Work Captcha Form Field extension for Silverstripe's [SpamProtection Module](https://github.com/silverstripe/silverstripe-spamprotection).

The "Proof of Work" mechanism leverages SHA256 hashing to maximize the computational power of the client's device, significantly deterring Spam-Bots from flooding your forms.


## Requirements

* Compatible with Silverstripe versions 4 and 5
* Requires SpamProtection Module version 3 or higher


## Installation

Install using Composer:
```sh
composer require minimalic/silverstripe-cryptoprotect
```

Then, set CryptoProtect as the default captcha in your project's config (`spamprotection.yml`):
```yaml
SilverStripe\SpamProtection\Extension\FormSpamProtectionExtension:
  default_spam_protector: minimalic\CryptoProtect\Forms\CryptographicChallengeProtector
```

Refresh your database by navigating to your website's root directory in the shell and running:
`vendor/bin/sake dev/build "flush=all"`

Or use your base URL with:
`/dev/build?flush=all`

In the CMS, navigate to the "cryptographic-challenges" area and generate new hashes.


## Configuration

Fine-tune the hashing mechanism in your project's config (`spamprotection.yml`). The currently available options with default values:
```yaml
minimalic\CryptoProtect\Models\CryptographicChallenge:
  difficulty_cycles: 100000
  hashes_count: 20
```
Note: Increasing `difficulty_cycles` may extend calculation times on slower devices (client-side).
A higher `hashes_count` requires more time for hash regeneration (server-side).

Remember to flush your caches (`?flush=all`) and regenerate hashes in the CMS whenever adjusting the configuration.

For more detailed information on configuring and utilizing the Spam Protection Field, visit the [SpamProtection Module](https://github.com/silverstripe/silverstripe-spamprotection) repository.


## License

See [License](LICENSE.md)

Copyright (c) 2024, minimalic.com - Sebastian Finke
All rights reserved.

