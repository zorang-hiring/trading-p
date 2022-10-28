<?php

namespace App\Gateway\CompanyList;

use App\Entity\CompaniesList;
use App\Entity\Company;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

class DataHubNasdaqCompanyListAdapter implements CompanyListAdapterInterface
{
    public function getCompanies(): CompaniesList
    {
        $response = $this->getClient()->request(
            'GET',
            'https://pkgstore.datahub.io/core/nasdaq-listings/nasdaq-listed_json/data/' .
            'a5bc7580d6176d60ac0b2142ca8d7df6/nasdaq-listed_json.json'
        );

        if ($response->getStatusCode() !== 200) {
            throw new \RuntimeException('Wrong gateway response');
        }

        $result = new CompaniesList();
        foreach (json_decode($response->getBody(), true) as $item) {
            $result->addCompany(new Company($item['Symbol'], $item['Company Name']));
        }
        return $result;
    }

    protected function getClient(): ClientInterface
    {
        return new Client();
    }
}