<?php

namespace DNADesign\SubsitesDefaultEmails\Extension;

use SilverStripe\Control\Email\Email;
use SilverStripe\Core\Config\Config;
use SilverStripe\Core\Environment;
use SilverStripe\Core\Extension;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\EmailField;
use SilverStripe\Forms\FieldList;

/* Adds a DefaultFromEmail field to the Subsite DataObject */

class DefaultEmailExtension extends Extension
{
    private static $db = [
        'DefaultFromEmail' => 'Varchar',
        'BypassEnvironment' => 'Boolean'
    ];

    /**
     * Update Fields
     */
    public function updateCMSFields(FieldList $fields)
    {
        $adminEmail = Config::inst()->get(Email::class, 'admin_email') ?? '-- not set --';
        $envEmail = Environment::getEnv('SS_EMAIL_SEND_ALL_FROM');
        $finalEmail = $envEmail ?? $adminEmail;

        $emailField = EmailField::create('DefaultFromEmail')->setDescription(
            'This field can be used to set the default "From" address for emails sent from this subsite. <br>
            If not set, defaults to'.$finalEmail
        );

        $fields->addFieldToTab('Root.Main', $emailField, 'Language');

        if ($envEmail) {
            $override = CheckboxField::create('BypassEnvironment')->setDescription('Bypass SS_EMAIL_SEND_ALL_FROM ('.$envEmail.') and use "Default From Email" on this subsite');
            $fields->addFieldToTab('Root.Main', $override, 'Language');
        }
    }
}