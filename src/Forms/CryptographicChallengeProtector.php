<?php

namespace minimalic\CryptoProtect\Forms;

use SilverStripe\SpamProtection\SpamProtector;

class CryptographicChallengeProtector implements SpamProtector {

   public function getFormField($name = null, $title = null, $value = null) {
       // return CryptographicChallengeField::create($name, $title);
       return CryptographicChallengeField::create($name, '');
   }

    // required function for 'SpamProtector'
   public function setFieldMapping($fieldMapping) {
   }
}
