<?php

namespace App\Service\CompanyListAdapter;

class DataHubNasdaqCompanyListAdapter implements CompanyListAdapterInterface
{
    public function getCompanies(): CompaniesListDto
    {
        return new CompaniesListDto();
    }
}