<?php

namespace App\Service\CompanyService;

interface CompanyListAdapterInterface
{
    public function getCompanies(): CompaniesListDto;
}