<?php

namespace minimalic\CryptoProtect\Models;

use SilverStripe\ORM\DataObject;

class CryptographicChallenge extends DataObject {

    private static string $table_name = 'CryptographicChallenge';

    // good entry point is above 100000 - set for your needs inside your YAML (more in documentation)
    private static $difficulty_cycles = 100000;

    // number of different hashes to generate
    private static $hashes_count = 20;

    // Question: public, needed for JS calculation
    // AnswerHash: secret, frontend calculated hash should match this backend calculated hash
    private static $db = [
        'Question' => 'Varchar',
        'AnswerHash' => 'Varchar(255)',
    ];

    // summary titles for CMS view
    public function summaryFields() {
        return [
            'Question' => _t(__CLASS__ . '.Question', 'Question'),
            'AnswerHash' => _t(__CLASS__ . '.AnswerHash', 'Answer Hash'),
        ];
    }

    public function getCMSFields() {
        $fields = parent::getCMSFields();

        $fields->dataFieldByName('Question')->setTitle(_t(__CLASS__ . '.Question', 'Question'));
        $fields->dataFieldByName('Question')->setReadonly(true);
        $fields->dataFieldByName('AnswerHash')->setTitle(_t(__CLASS__ . '.AnswerHash', 'Answer Hash'));
        $fields->dataFieldByName('AnswerHash')->setReadonly(true);

        return $fields;
    }

}
