<?php

namespace App\Tests\Service\CompanyService;


use App\Entity\CompaniesList;
use App\Entity\Company;
use App\Gateway\CompanyListGateway\CompanyListAdapterInterface;

class CompanyServiceAdapterStub implements CompanyListAdapterInterface
{
    protected array $dataStub = [
        [
            "Company Name" => "iShares MSCI All Country Asia Information Technology Index Fund",
            "Financial Status" => "N",
            "Market Category" => "G",
            "Round Lot Size" => 100.0,
            "Security Name" => "iShares MSCI All Country Asia Information Technology Index Fund",
            "Symbol" => "AAIT",
            "Test Issue" => "N"
        ],
        [
            "Company Name" => "American Airlines Group, Inc.",
            "Financial Status" => "N",
            "Market Category" => "Q",
            "Round Lot Size" => 100.0,
            "Security Name" => "American Airlines Group, Inc. - Common Stock",
            "Symbol" => "AAL",
            "Test Issue" => "N"
        ]
    ];

    public function getCompanies(): CompaniesList
    {
        $result = new CompaniesList();
        foreach ($this->dataStub as $item) {
            $result->addCompany(
                new Company($item['Symbol'])
            );
        }
        return $result;
    }
}