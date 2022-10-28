<?php

namespace App\Service\MailerService;

use DateTimeInterface;

class RetrieveCompanyQuotesNotificationDto
{
    protected string $toMail;
    protected string $forCompanyName;
    public DateTimeInterface $startDate;
    public DateTimeInterface $endDate;
}