<?php

namespace App\Service\CompanyService;

class DataHubNasdaqCompanyListAdapter implements CompanyListAdapterInterface
{
    public function getCompanies(): CompaniesListDto
    {
        return new CompaniesListDto();
    }
}