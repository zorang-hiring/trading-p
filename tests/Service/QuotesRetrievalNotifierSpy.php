<?php

namespace App\Tests\Service;

use App\Dto\RetrieveCompanyQuotesNotificationDto;
use App\Service\QuotesRetrievalNotifierInterface;

class QuotesRetrievalNotifierSpy implements QuotesRetrievalNotifierInterface
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
