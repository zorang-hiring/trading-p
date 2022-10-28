<?php

namespace App\Service;

use DateTimeInterface;

interface CompanyHistoryQuotesServiceInterface
{
    public function getQuotes(string $companySymbol, DateTimeInterface $startDate, DateTimeInterface $endDate);
}