<?php

namespace App\Tests\Service\CompanyHistoryQuotesAdapter;

use App\Service\QuotesAdapter\CompanyHistoryQuotesAdapterInterface;
use App\Service\QuotesAdapter\QuoteDto;
use App\Service\QuotesAdapter\QuotesListDto;

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

    public function getQuotes(string $companySymbol): QuotesListDto
    {
        $this->requestedParamsSpy['companySymbol'] = $companySymbol;

        $result = new QuotesListDto();
        foreach ($this->stubData['prices'] as $data) {
            $quote = new QuoteDto();
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
