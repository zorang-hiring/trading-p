<?php

namespace App\Tests\Gateway\Quotes;

use App\Entity\Quote;
use App\Entity\QuotesList;
use App\Gateway\Quotes\CompanyHistoryQuotesAdapterInterface;

class CompanyHistoryQuotesAdapterSpy implements CompanyHistoryQuotesAdapterInterface
{
    protected array $requestedParamsSpy;

    protected array $stubData;

    public function __construct()
    {
        $this->reset();
    }

    public function reset(): void
    {
        $this->requestedParamsSpy = [
            'companySymbol' => null
        ];
        $this->stubData = [
            'prices' => []
        ];
    }

    public function getRequestedParamsSpy(): array
    {
        return $this->requestedParamsSpy;
    }

    public function setStubData(array $data)
    {
        $this->stubData['prices'] = $data;
    }

    public function getQuotes(string $companySymbol): QuotesList
    {
        $this->requestedParamsSpy['companySymbol'] = $companySymbol;

        $result = new QuotesList();
        foreach ($this->stubData['prices'] as $data) {
            $quote = new Quote();
            $quote->date = $data['date'];
            $quote->open = $data['open'];
            $quote->high = $data['high'];
            $quote->low = $data['low'];
            $quote->close = $data['close'];
            $quote->volume = $data['volume'];
            $result->addQuote($quote);
        }
        return $result;
    }
}
