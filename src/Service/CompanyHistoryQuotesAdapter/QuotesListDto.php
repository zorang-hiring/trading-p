<?php

namespace App\Service\CompanyHistoryQuotesAdapter;

class QuotesListDto
{
    protected array $data = [];

    public function addQuote(QuoteDto $quote): void
    {
        $this->data[] = $quote;
    }

    public function getQuotes(): array
    {
        return $this->data;
    }
}