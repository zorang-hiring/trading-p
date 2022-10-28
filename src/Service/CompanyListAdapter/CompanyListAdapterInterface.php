<?php

namespace App\Service\CompanyListAdapter;

interface CompanyListAdapterInterface
{
    public function getCompanies(): CompaniesListDto;
}