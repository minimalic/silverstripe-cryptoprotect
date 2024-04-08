# Silverstripe CryptoProtect

Proof of Work Captcha Field as extension for Silverstripe's [SpamProtection Module](https://github.com/silverstripe/silverstripe-spamprotection).

The "Proof of Work" mechanism uses multiple SHA256 calculation to utilize computation capability of client's device for reducing Spam-Bots form requests.


## Requirements

* Silverstripe 4 or Silverstripe 5
* SpamProtection Module 3 or higher


## Installation

```sh
composer require minimalic/silverstripe-cryptoprotect
```

Enable as default captcha in your project's config (spamprotection.yml):
```yaml
SilverStripe\SpamProtection\Extension\FormSpamProtectionExtension:
  default_spam_protector: minimalic\CryptoProtect\Forms\CryptographicChallengeProtector
```

Refresh DB (shell website root):
`vendor/bin/sake dev/build "flush=all"`

Or use base URL with:
`/dev/build?flush=all`

Inside CMS use the "cryptoprotect" area and generate new hashes.


## Configuration

You can tune the hashing behavior inside your project's config (spamprotection.yml). Currently avvailable options (default):
```yaml
minimalic\CryptoProtect\Models\CryptographicChallenge:
  difficulty_cycles: 100000
```
Flush caches with `?flush=all` and regenerate hashes inside CMS after config changes.


More on configuring and using Spam Protection Field inside [SpamProtection Module](https://github.com/silverstripe/silverstripe-spamprotection) repository.


## License

See [License](LICENSE.md)

Copyright (c) 2024, minimalic.com - Sebastian Finke
All rights reserved.

