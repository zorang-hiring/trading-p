<?php

namespace App\Gateway\QuotesGateway;

use App\Entity\QuotesList;

interface CompanyHistoryQuotesAdapterInterface
{
    public function getQuotes(string $companySymbol): QuotesList;
}