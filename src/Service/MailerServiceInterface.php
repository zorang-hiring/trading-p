<?php

namespace App\Service;

use App\Service\MailerService\RetrieveCompanyQuotesNotificationDto;

interface MailerServiceInterface
{
    public function sendQuoteNotification(RetrieveCompanyQuotesNotificationDto $notification): void;
}