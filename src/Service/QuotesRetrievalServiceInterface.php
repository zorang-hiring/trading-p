<?php

namespace App\Service;

use DateTimeInterface;

interface QuotesRetrievalServiceInterface
{
    public function retrieveQuotes(string $companySymbol, DateTimeInterface $startDate, DateTimeInterface $endDate);
}