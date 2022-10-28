<?php

namespace App\Service;

interface CompanyHistoryQuotesServiceInterface
{
    public function getQuotes(string $companySymbol, string $startDate, string $endDate);
}