<?php

namespace App\Service;

use App\Service\QuoteRetrievalNotifier\RetrieveCompanyQuotesNotificationDto;

interface QuoteRetrievalNotifierInterface
{
    public function notify(RetrieveCompanyQuotesNotificationDto $notification): void;
}