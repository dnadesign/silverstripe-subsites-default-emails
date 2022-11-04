<?php

namespace DNADesign\SubsitesDefaultEmails\Control\Email;

use DateTime;
use SilverStripe\Control\Email\Email as CoreEmail;
use SilverStripe\ORM\FieldType\DBDatetime;
use SilverStripe\Subsites\Model\Subsite;
use Swift_Message;
use Swift_Mime_SimpleMessage;

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
            $message = new Swift_Message(null, null, 'text/html', 'utf-8');
            // Set priority to fix PHP 8.1 SimpleMessage::getPriority() sscanf() null parameter
            $message->setPriority(Swift_Mime_SimpleMessage::PRIORITY_NORMAL);
            $this->setSwiftMessage($message);
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
        $dateTime = new DateTime();
        $dateTime->setTimestamp(DBDatetime::now()->getTimestamp());
        $swiftMessage->setDate($dateTime);
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
