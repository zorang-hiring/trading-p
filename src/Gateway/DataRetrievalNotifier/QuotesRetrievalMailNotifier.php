<?php

namespace App\Gateway\DataRetrievalNotifier;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class QuotesRetrievalMailNotifier implements QuotesRetrievalNotifierInterface
{
    public function __construct(
        protected MailerInterface $mailer
    ){}

    public function notify(QuotesRetrievalNotificationDto $notification): void
    {
        $bodyText = sprintf('From %s to %s', $notification->startDate, $notification->endDate);

        $email = (new Email())
            ->from('noreply@todo.com')
            ->to($notification->recipient)
            ->subject($notification->forCompanyName)
            ->text($bodyText)
            ->html('<p>' . $bodyText . '</p>');

        $this->mailer->send($email);
    }
}