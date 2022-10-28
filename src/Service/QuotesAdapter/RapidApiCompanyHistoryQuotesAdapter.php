<?php

namespace App\Service\QuotesAdapter;

use App\Entity\QuotesListDto;

class RapidApiCompanyHistoryQuotesAdapter implements CompanyHistoryQuotesAdapterInterface
{
    public function getQuotes(string $companySymbol): QuotesListDto
    {
        return new QuotesListDto();
    }
}