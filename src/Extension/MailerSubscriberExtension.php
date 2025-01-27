<?php

namespace DNADesign\SubsitesDefaultEmails\Extension;

use SilverStripe\Core\Environment;
use SilverStripe\Core\Extension;
use SilverStripe\Subsites\Model\Subsite;

/* Overrides the DefaultFrom address for a subsite. */

class MailerSubscriberExtension extends Extension
{
    /**
     * Update $defaultFrom variable if $subsite->DefaultFromEmail has been set
     */
    public function updateOnMessage($email)
    {
        $envEmail = Environment::getEnv('SS_SEND_ALL_EMAILS_FROM');
        $subsite = Subsite::currentSubsite();

        if ($subsite && trim($subsite->DefaultFromEmail) ?? '') {
            if (!$envEmail || ($envEmail && $subsite->BypassEnvironment)) {
                $email->setFrom($subsite->DefaultFromEmail);
            }
        }
    }
}
