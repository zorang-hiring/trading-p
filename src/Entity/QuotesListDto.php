<?php

namespace App\Entity;

class QuotesListDto
{
    /**
     * @var QuoteDto[]
     */
    protected array $data = [];

    public function addQuote(QuoteDto $quote): void
    {
        $this->data[] = $quote;
    }

    /**
     * @return QuoteDto[]
     */
    public function getQuotes(): array
    {
        return $this->data;
    }
}