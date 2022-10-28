<?php

namespace App\Service\QuotesAdapter;

interface CompanyHistoryQuotesAdapterInterface
{
    public function getQuotes(string $companySymbol): QuotesListDto;
}