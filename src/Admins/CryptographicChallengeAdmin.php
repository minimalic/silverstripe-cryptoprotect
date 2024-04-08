<?php

namespace minimalic\CryptoProtect\Admins;

use SilverStripe\Security\Permission;
use SilverStripe\Admin\ModelAdmin;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Forms\GridField\GridFieldConfig;

use minimalic\CryptoProtect\Models\CryptographicChallenge;
use minimalic\CryptoProtect\Forms\GridFieldGenerateHashesButton;

class CryptographicChallengeAdmin extends ModelAdmin {

    private static $managed_models = [
        CryptographicChallenge::class,
    ];

    private static $url_segment = 'cryptographic-challenges';
    private static $menu_title = 'Cryptographic Challenges';

    private static $allowed_actions = ['generateHashes'];

    protected function getGridFieldConfig(): GridFieldConfig
    {
        $config = parent::getGridFieldConfig();

        if (Permission::check('ADMIN')) {
            if ($this->modelClass === CryptographicChallenge::class) {
                $config->addComponent(new GridFieldGenerateHashesButton());
            }
        }

        return $config;
    }

    public function generateHashes(HTTPRequest $request) {
        if (!Permission::check('ADMIN')) {
            return $this->httpError(403, _t(__CLASS__ . '.AdminAccess', 'You do not have access to this action'));
        }

        $cycles = CryptographicChallenge::config()->get('difficulty_cycles');
        $challenges = [];

        for ($i = 0; $i < 20; $i++) {
            $id = $i + 1;
            $question = "Challenge_" . mt_rand(10000000, 99999999);
            $answer = hash('sha256', $question);
            for ($h = 0; $h < $cycles; $h++) {
                $answer = hash('sha256', $answer);
            }

            $challenges[] = [
                'id' => $id,
                'question' => $question,
                'answer_hash' => $answer
            ];
        }

        foreach ($challenges as $challenge) {
            $newChallenge = CryptographicChallenge::create();
            $newChallenge->ID = $challenge['id'];
            $newChallenge->Question = $challenge['question'];
            $newChallenge->AnswerHash = $challenge['answer_hash'];
            $newChallenge->write();
        }

        return $this->redirectBack();
    }
}
