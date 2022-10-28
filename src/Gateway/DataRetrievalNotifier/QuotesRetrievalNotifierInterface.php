<?php

namespace App\Gateway\DataRetrievalNotifier;

interface QuotesRetrievalNotifierInterface
{
    public function notify(QuotesRetrievalNotificationDto $notification): void;
}