<?php

namespace App\Entity;

class QuotesList
{
    /**
     * @var Quote[]
     */
    protected array $data = [];

    public function addQuote(Quote $quote): void
    {
        $this->data[] = $quote;
    }

    /**
     * @return Quote[]
     */
    public function getQuotes(): array
    {
        return $this->data;
    }
}