<?php

namespace App\Gateway\CompanyList;

use App\Entity\CompaniesList;
use App\Entity\Company;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Psr\Http\Message\ResponseInterface;

class DataHubNasdaqCompanyListAdapter implements CompanyListAdapterInterface
{
    public function getCompanies(): CompaniesList
    {
        $response = $this->makeRequest();

        if ($response->getStatusCode() !== 200) {
            throw new \RuntimeException('Wrong gateway response');
        }

        return $this->buildResult($response);
    }

    protected function getClient(): ClientInterface
    {
        return new Client();
    }

    private function makeRequest(): ResponseInterface
    {
        return $this->getClient()->request(
            'GET',
            'https://pkgstore.datahub.io/core/nasdaq-listings/nasdaq-listed_json/data/' .
            'a5bc7580d6176d60ac0b2142ca8d7df6/nasdaq-listed_json.json'
        );
    }

    private function buildResult(ResponseInterface $response): CompaniesList
    {
        $result = new CompaniesList();
        foreach (json_decode($response->getBody(), true) as $item) {
            $result->addCompany(new Company($item['Symbol'], $item['Company Name']));
        }
        return $result;
    }
}