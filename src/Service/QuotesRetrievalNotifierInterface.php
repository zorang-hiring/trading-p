<?php

namespace App\Service;

use App\Dto\RetrieveCompanyQuotesNotificationDto;

interface QuotesRetrievalNotifierInterface
{
    public function notify(RetrieveCompanyQuotesNotificationDto $notification): void;
}