<?php

namespace App\Service\CompanyHistoryQuotesAdapter;

class QuotesListDto
{
    protected array $data = [];

    public function addQuote(QuoteDto $quote): void
    {
        $this->data[] = $quote;
    }
}