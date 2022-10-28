<?php

namespace App\Tests\Service;

use App\Service\QuoteRetrievalNotifier\RetrieveCompanyQuotesNotificationDto;
use App\Service\QuoteRetrievalNotifierInterface;

class QuoteRetrievalNotifierSpy implements QuoteRetrievalNotifierInterface
{
    /**
     * @var RetrieveCompanyQuotesNotificationDto[]
     */
    protected array $notifications = [];

    public function notify(RetrieveCompanyQuotesNotificationDto $notification): void
    {
        $this->notifications[] = $notification;
    }

    /**
     * @return RetrieveCompanyQuotesNotificationDto[]
     */
    public function getNotifications(): array
    {
        return $this->notifications;
    }
}
