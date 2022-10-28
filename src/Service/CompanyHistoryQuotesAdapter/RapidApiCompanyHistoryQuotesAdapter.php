<?php

namespace App\Service\CompanyHistoryQuotesAdapter;

class RapidApiCompanyHistoryQuotesAdapter implements CompanyHistoryQuotesAdapterInterface
{
    public function getQuotes(string $companySymbol): QuotesListDto
    {
        return new QuotesListDto();
    }
}