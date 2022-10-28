<?php

namespace App\Service\CompanyHistoryQuotesAdapter;

interface CompanyHistoryQuotesAdapterInterface
{
    public function getQuotes(string $companySymbol): QuotesListDto;
}