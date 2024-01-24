<?php

namespace DNADesign\SubsitesDefaultEmails\Extension;

use SilverStripe\Core\Extension;
use SilverStripe\Subsites\Model\Subsite;

/* Overrides the DefaultFrom address for a subsite. */

class EmailExtension extends Extension
{
    /**
     * Update $defaultFrom variable if $subsite->DefaultFromEmail has been set
     */
    public function updateDefaultFrom(&$defaultFrom)
    {
        $subsite = Subsite::currentSubsite();
        if ($subsite && $subsite->DefaultFromEmail) {
            $defaultFrom = $subsite->DefaultFromEmail;
        }
    }
}
