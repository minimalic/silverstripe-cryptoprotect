<?php

namespace minimalic\CryptoProtect\Models;

use SilverStripe\ORM\DataObject;

class CryptographicChallenge extends DataObject {

    private static string $table_name = 'CryptographicChallenge';

    /**
     * Number of hash cycles for difficulty tuning.
     * Good entry point is above 100000 - set for your needs inside your YAML (more in documentation).
     *
     * @int
     */
    private static $difficulty_cycles = 100000;

    /**
     * Number of different hashes to generate
     *
     * @int
     */
    private static $hashes_count = 20;

    /**
     * Hide input field by using one of available options:
     * 'bootstrap' (default, use the "visually-hidden" class),
     * 'style' (use a "display: none" inline style),
     * 'none' (show the input field)
     *
     * @string
     */
    private static $hide_input_by = 'bootstrap';

    /**
     * Display a loading spinner/complete checkmark and status text
     *
     * @bool
     */
    private static $show_calculation_status = true;

    /**
     * Display a progress bar
     *
     * @bool
     */
    private static $show_progress_bar = true;

    /**
     * Hide the spinner/status and/or the progress bar after 4 seconds
     *
     * @bool
     */
    private static $hide_after_solving = true;

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
