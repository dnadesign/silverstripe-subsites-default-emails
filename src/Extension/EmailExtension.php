<?php

namespace DNADesign\SubsitesDefaultEmails\Extension;

use SilverStripe\Core\Extension;
use SilverStripe\Control\Email\Email;
use SilverStripe\Subsites\Model\Subsite;

/**
 * Overrides the DefaultFrom address for a subsite.
 *
 * @extends Extension<Email>
 */
class EmailExtension extends Extension
{
    /**
     * Update $defaultFrom variable if $subsite->DefaultFromEmail has been set
     */
    protected function updateDefaultFrom(string &$defaultFrom): void
    {
        $subsite = Subsite::currentSubsite();
        if ($subsite && trim((string)$subsite->DefaultFromEmail)) {
            $defaultFrom = $subsite->DefaultFromEmail;
        }
    }
}
