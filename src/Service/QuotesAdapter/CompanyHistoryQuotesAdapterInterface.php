<?php

namespace App\Service\QuotesAdapter;

use App\Entity\QuotesListDto;

interface CompanyHistoryQuotesAdapterInterface
{
    public function getQuotes(string $companySymbol): QuotesListDto;
}