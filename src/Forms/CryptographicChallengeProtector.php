<?php

namespace minimalic\CryptoProtect\Forms;

use SilverStripe\SpamProtection\SpamProtector;

class CryptographicChallengeProtector implements SpamProtector {

   // provides protector field for SpamProtection Module
   public function getFormField($name = null, $title = null, $value = null) {
       return CryptographicChallengeField::create($name, '');
   }

    // required function for 'SpamProtector'
   public function setFieldMapping($fieldMapping) {
   }
}
