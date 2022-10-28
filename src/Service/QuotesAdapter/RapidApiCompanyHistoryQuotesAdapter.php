<?php

namespace App\Service\QuotesAdapter;

class RapidApiCompanyHistoryQuotesAdapter implements CompanyHistoryQuotesAdapterInterface
{
    public function getQuotes(string $companySymbol): QuotesListDto
    {
        return new QuotesListDto();
    }
}