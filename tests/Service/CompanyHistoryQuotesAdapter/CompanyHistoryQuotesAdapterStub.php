<?php

namespace App\Tests\Service\CompanyHistoryQuotesAdapter;

use App\Service\CompanyHistoryQuotesAdapter\CompanyHistoryQuotesAdapterInterface;
use App\Service\CompanyHistoryQuotesAdapter\QuoteDto;
use App\Service\CompanyHistoryQuotesAdapter\QuotesListDto;

class CompanyHistoryQuotesAdapterStub implements CompanyHistoryQuotesAdapterInterface
{
    protected array $stubData = [
        'prices' => [
            [
                "date" => 1666970264,
                "open" => 136.3800048828125,
                "high" => 137.34500122070312,
                "low" => 135.0500030517578,
                "close" => 136.85000610351562,
                "volume" => 313087
            ]
        ]
    ];

    public function getQuotes(string $companySymbol): QuotesListDto
    {
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
