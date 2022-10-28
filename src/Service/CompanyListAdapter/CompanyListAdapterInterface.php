<?php

namespace App\Service\CompanyListAdapter;

use App\Entity\CompaniesListDto;

interface CompanyListAdapterInterface
{
    public function getCompanies(): CompaniesListDto;
}