<?php

namespace App\Gateway\QuotesGateway;

use App\Entity\QuotesListDto;

interface CompanyHistoryQuotesAdapterInterface
{
    public function getQuotes(string $companySymbol): QuotesListDto;
}