<?php

namespace minimalic\CryptoProtect\Models;

use SilverStripe\ORM\DataObject;

class CryptographicChallenge extends DataObject {

    private static string $table_name = 'CryptographicChallenge';

    // good entry point is above 100000 - set for your needs inside your YAML (more in documentation)
    private static $difficulty_cycles = 100000;

    private static $db = [
        'Question' => 'Varchar',
        'AnswerHash' => 'Varchar(255)',
    ];

//     private static $summary_fields = [
//         'Question' => 'QuestionLabel',
//         'AnswerHash' => 'AnswerHashLabel',
//     ];
//
//     public function QuestionLabel() {
//         return _t(__CLASS__ . '.Question', 'Question');
//     }
//
//     public function AnswerHashLabel() {
//         return _t(__CLASS__ . '.AnswerHash', 'Answer Hash');
//     }

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
