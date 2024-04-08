<?php

namespace minimalic\CryptoProtect\Forms;

use SilverStripe\Control\Controller;
use SilverStripe\Forms\GridField\GridFieldComponent;
use SilverStripe\Forms\GridField\GridField_HTMLProvider;
use SilverStripe\Forms\GridField\GridField_ActionProvider;
use SilverStripe\Forms\GridField\GridField;

use minimalic\CryptoProtect\Models\CryptographicChallenge;
use minimalic\CryptoProtect\Admins\CryptographicChallengeAdmin;

class GridFieldGenerateHashesButton implements GridFieldComponent, GridField_HTMLProvider, GridField_ActionProvider {

    public function getHTMLFragments($gridField) {
        $adminLink = singleton(CryptographicChallengeAdmin::class)->Link();
        $challengeClass = str_replace('\\', '-', CryptographicChallenge::class);
        $link = Controller::join_links(
            $adminLink,
            $challengeClass,
            'generateHashes'
        );

        $buttonTitle = _t(__CLASS__ . '.ButtonTitle', 'Generate New Hashes');
        $button = sprintf(
            '<a class="btn btn-primary action_generateHashes" href="%s">' . $buttonTitle . '</a>',
            $link
        );

        return [
            'before' => $button,
        ];
    }

    public function getActions($gridField) {
        return ['generateHashes'];
    }

    public function handleAction(GridField $gridField, $actionName, $arguments, $data) {
        if ($actionName == 'generateHashes') {

        }
    }
}
