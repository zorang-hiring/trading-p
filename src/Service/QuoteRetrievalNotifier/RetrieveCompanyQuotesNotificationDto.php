<?php

namespace App\Service\QuoteRetrievalNotifier;

use DateTimeInterface;

class RetrieveCompanyQuotesNotificationDto
{
    public string $recipient;
    public string $forCompanyName;
    public string $startDate;
    public string $endDate;
}