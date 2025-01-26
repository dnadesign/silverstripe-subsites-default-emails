<?php

namespace DNADesign\SubsitesDefaultEmails\Extension;

use SilverStripe\Control\Email\Email;
use SilverStripe\Core\Config\Config;
use SilverStripe\Core\Extension;
use SilverStripe\Forms\EmailField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Subsites\Model\Subsite;

/* Adds a DefaultFromEmail field to the Subsite DataObject */

class DefaultEmailExtension extends Extension
{
    private static $db = [
        'DefaultFromEmail' => 'Varchar'
    ];

    /**
     * Update Fields
     */
    public function updateCMSFields(FieldList $fields)
    {
        $adminEmail = Config::inst()->get(Email::class, 'admin_email') ?? '-- not set --';

        $emailField = EmailField::create('DefaultFromEmail')->setDescription(
            'This field can be used to set the default "From" address for emails sent from this subsite. <br>
            If not set, defaults to '.$adminEmail
        );

        if (Subsite::currentSubsite()) {
            $fields->replaceField('DefaultFromEmail', $emailField);
        } else {
            $fields->removeByName('DefaultFromEmail');
        }
    }
}