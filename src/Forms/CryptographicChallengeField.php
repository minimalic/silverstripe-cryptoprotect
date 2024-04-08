<?php

namespace minimalic\CryptoProtect\Forms;

use SilverStripe\Control\Controller;

use SilverStripe\View\Requirements;

use SilverStripe\Forms\FormField;

use minimalic\CryptoProtect\Models\CryptographicChallenge;

class CryptographicChallengeField extends FormField {

    private static $enabled = true;

    public function Field($properties = []) {
        if ($this->config()->get('enabled')) {
            $challenge = CryptographicChallenge::get()->shuffle()->first();

            if ($challenge) {
                // Store challenge ID in session
                Controller::curr()->getRequest()->getSession()->set('CryptographicChallengeID', $challenge->ID);

                // Pass the challenge data to the template
                $this->setAttribute('data-challenge-id', $challenge->ID);
                $this->setAttribute('data-challenge-question', $challenge->Question);

                $cycles = CryptographicChallenge::config()->get('difficulty_cycles');
                $this->setAttribute('data-challenge-difficulty', $cycles);

                $textSolving = _t(__CLASS__ . '.CaptchaSolving', "Solving captcha...");
                $this->setAttribute('data-challenge-text-solving', $textSolving);

                $textSolved = _t(__CLASS__ . '.CaptchaSolved', "Captcha solved");
                $this->setAttribute('data-challenge-text-solved', $textSolved);

                $textRightTitle = _t(
                    __CLASS__ . '.RightTitle',
                    "It seems like you've disabled JavaScript in your browser or something else gone wrong.
                     In this case you only can submit the form by solving captcha using terminal and some code:\n
                     1. get SHA-256 from following text: {question}
                     2. get the created SHA-256 and make a new one from the previous one while repeating this step for a total number of 200,000 times.
                     3. paste the last SHA-256 into the captcha field above.",
                    ['question' => $challenge->Question]
                );
                $this->setRightTitle($textRightTitle);

                Requirements::javascript('minimalic/silverstripe-cryptoprotect: client/dist/js/cryptographicchallenge.js');

                return parent::Field($properties);
            }
        }
    }

    public function isCorrectAnswer($answer, $challengeid) {
        $challenge = CryptographicChallenge::get()->byID($challengeid);

//         // Temporary debug output
//         echo 'Expected Hash: ' . $challengeid . ' ' . $challenge->AnswerHash . '<br>';
//         echo 'Submitted Answer: ' . $answer . '<br>';
//         exit;

        if ($challenge && $challenge->AnswerHash == $answer) {
            return true;
        }

        return false;
    }

    public function validate($validator) {

        $request = Controller::curr()->getRequest();
        $value = $request->postVar($this->getName());

        if (!$value) {
            $value = $this->Value();
        }

        $challengeid = $request->getSession()->get('CryptographicChallengeID');

        if ($challengeid) {
            if ($this->isCorrectAnswer($value, $challengeid)) {
                // Clear the session variable after successful validation
                Controller::curr()->getRequest()->getSession()->clear('CryptographicChallengeID');
                return true;
            } else {
                $validator->validationError(
                    $this->name,
                    _t(__CLASS__ . '.ValidationError', "The provided answer is incorrect. Captcha will be solved again.\n If you cannot pass the captcha try different browser or different device."),
                    "validation"
                );
                return false;
            }
        }

        return false;
    }
}
