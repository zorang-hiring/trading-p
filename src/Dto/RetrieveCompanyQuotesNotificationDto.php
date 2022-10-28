<?php

namespace App\Dto;

class RetrieveCompanyQuotesNotificationDto
{
    public string $recipient;
    public string $forCompanyName;
    public string $startDate;
    public string $endDate;
}