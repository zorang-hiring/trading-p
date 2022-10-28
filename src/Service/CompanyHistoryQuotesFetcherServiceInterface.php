<?php

namespace App\Service;

interface CompanyHistoryQuotesFetcherServiceInterface
{
    public function getQuotes(string $companySymbol, string $startDate, string $endDate);
}