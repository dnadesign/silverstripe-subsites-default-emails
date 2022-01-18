<?php

namespace DNADesign\SubsitesDefaultEmails\Extension;

use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;

/* Adds a DefaultFromEmail field to the Subsite DataObject */

class DefaultEmailExtension extends DataExtension
{
    private static $db = [
        'DefaultFromEmail' => 'Varchar'
    ];

    /**
     * Update Fields
     * @return FieldList
     */
    public function updateCMSFields(FieldList $fields)
    {
        $fields->dataFieldByName('DefaultFromEmail')->setDescription(
            'This field can be used to set the default "From" address for emails sent from this subsite. <br>
            If not set, then the value set for "admin email" in this sites application config will be used instead.'
        );
        return $fields;
    }
}
