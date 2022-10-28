<?php

namespace App\Gateway\CompanyListGateway;

use App\Entity\CompaniesListDto;

interface CompanyListAdapterInterface
{
    public function getCompanies(): CompaniesListDto;
}