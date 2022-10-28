<?php

namespace App\Gateway\Quotes;

use App\Entity\Quote;
use App\Entity\QuotesList;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Psr\Http\Message\ResponseInterface;

class RapidApiCompanyHistoryQuotesAdapter implements CompanyHistoryQuotesAdapterInterface
{
    protected array $credentials;

    public function __construct(string $apiKey, string $apiHost)
    {
        $this->credentials = [
            'key' => $apiKey,
            'host' => $apiHost
        ];
    }

    public function getCredentials()
    {
        // todo test DI configuration
    }

    public function getQuotes(string $companySymbol): QuotesList
    {
        $response = $this->makeRequest($companySymbol);

        if ($response->getStatusCode() !== 200) {
            throw new \RuntimeException('Wrong gateway response');
        }

        return $this->buildResult($response);
    }

    protected function getClient(): ClientInterface
    {
        return new Client();
    }

    private function makeRequest(string $companySymbol): ResponseInterface
    {
        return $this->getClient()->request(
            'GET',
            'https://yh-finance.p.rapidapi.com/stock/v3/get-historical-data',
            [
                'query' => [
                    'symbol' => $companySymbol,
                    'region' => 'US'
                ],
                'headers' => [
                    'X-RapidAPI-Key' => $this->credentials['key'],
                    'X-RapidAPI-Host' => $this->credentials['host'],
                ]
            ]
        );
    }

    private function buildResult(ResponseInterface $response): QuotesList
    {
        $result = new QuotesList();
        foreach (json_decode($response->getBody(), true)['prices'] as $item) {
            $result->addQuote(
                $this->buildItem($item)
            );
        }
        return $result;
    }

    private function buildItem($item): Quote
    {
        $quote = new Quote();
        $quote->date = (int) $item['date'];
        $quote->open = (float) $item['open'];
        $quote->close = (float) $item['close'];
        $quote->low = (float) $item['low'];
        $quote->high = (float) $item['high'];
        $quote->volume = (int) $item['volume'];
        return $quote;
    }
}