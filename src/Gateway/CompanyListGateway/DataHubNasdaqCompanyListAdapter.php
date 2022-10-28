<?php

namespace App\Gateway\CompanyListGateway;

use App\Entity\CompaniesListDto;

class DataHubNasdaqCompanyListAdapter implements CompanyListAdapterInterface
{
    public function getCompanies(): CompaniesListDto
    {
        return new CompaniesListDto();
    }
}