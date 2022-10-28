<?php

namespace App\Tests\Service;

use App\Gateway\DataRetrievalNotifier\QuotesRetrievalNotificationDto;
use App\Gateway\DataRetrievalNotifier\QuotesRetrievalNotifierInterface;

class QuotesRetrievalNotifierSpy implements QuotesRetrievalNotifierInterface
{
    /**
     * @var QuotesRetrievalNotificationDto[]
     */
    protected array $notifications = [];

    public function notify(QuotesRetrievalNotificationDto $notification): void
    {
        $this->notifications[] = $notification;
    }

    /**
     * @return QuotesRetrievalNotificationDto[]
     */
    public function getNotifications(): array
    {
        return $this->notifications;
    }
}
