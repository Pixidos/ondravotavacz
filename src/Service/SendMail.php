<?php

declare(strict_types=1);

namespace App\Service;

use App\Configs\MailConfig;
use Swift_Mailer;
use Swift_Message;

class SendMail
{
    /**
     * @var Swift_Mailer
     */
    private $mailer;
    /**
     * @var MailConfig
     */
    private $config;

    /**
     * SendMail constructor.
     *
     * @param Swift_Mailer $mailer
     * @param MailConfig   $config
     */
    public function __construct(Swift_Mailer $mailer, MailConfig $config)
    {
        $this->mailer = $mailer;
        $this->config = $config;
    }

    /**
     * @param string $from
     * @param string $subject
     * @param string $message
     *
     * @return bool
     */
    public function send(string $from, string $subject, string $message): bool
    {
        $swiftMessage = new Swift_Message(
            $this->config->getSubjectPrefix() . $subject,
            $message
        );
        $swiftMessage
            ->setTo($this->config->getToMail())
            ->setFrom($this->config->getFromMail())
            ->setReplyTo($from);

        return (bool)$this->mailer->send($swiftMessage);
    }
}
