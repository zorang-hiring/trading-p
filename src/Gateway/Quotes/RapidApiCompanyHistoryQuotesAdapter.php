<?php

namespace App\Gateway\Quotes;

use App\Entity\QuotesList;

class RapidApiCompanyHistoryQuotesAdapter implements CompanyHistoryQuotesAdapterInterface
{
    public function getQuotes(string $companySymbol): QuotesList
    {
        return new QuotesList();
    }
}