<?php

namespace DNADesign\SubsitesDefaultEmails\Control\Email;

use SilverStripe\Control\Email\Email as CoreEmail;
use SilverStripe\ORM\FieldType\DBDatetime;
use SilverStripe\Subsites\Model\Subsite;
use Swift_Message;

/**
 * This class is used to override the setSwiftMessage function
 * so that the default "from" address can be set on a per subsite basis.
 */
class Email extends CoreEmail
{

    /**
     * @var Swift_Message
     */
    private $swiftMessage;

    /**
     * @return Swift_Message
     */
    public function getSwiftMessage()
    {
        if (!$this->swiftMessage) {
            $this->setSwiftMessage(new Swift_Message(null, null, 'text/html', 'utf-8'));
        }

        return $this->swiftMessage;
    }

    /**
     * @param Swift_Message $swiftMessage
     *
     * @return $this
     */
    public function setSwiftMessage($swiftMessage)
    {
        $swiftMessage->setDate(DBDatetime::now()->getTimestamp());
        if (!$swiftMessage->getFrom()) {
            $defaultFrom = $this->config()->get('admin_email');

            $subsite = Subsite::currentSubsite();
            if ($subsite && $subsite->DefaultFromEmail) {
                $defaultFrom = $subsite->DefaultFromEmail;
            }

            if ($defaultFrom) {
                $swiftMessage->setFrom($defaultFrom);
            }
        }
        $this->swiftMessage = $swiftMessage;
        return $this;
    }
}
