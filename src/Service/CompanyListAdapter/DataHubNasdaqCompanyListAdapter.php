<?php

namespace App\Service\CompanyListAdapter;

use App\Entity\CompaniesListDto;

class DataHubNasdaqCompanyListAdapter implements CompanyListAdapterInterface
{
    public function getCompanies(): CompaniesListDto
    {
        return new CompaniesListDto();
    }
}