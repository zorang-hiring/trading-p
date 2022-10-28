<?php

namespace App\Gateway\Quotes;

use App\Entity\QuotesList;

interface CompanyHistoryQuotesAdapterInterface
{
    public function getQuotes(string $companySymbol): QuotesList;
}