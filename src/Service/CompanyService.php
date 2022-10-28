<?php

namespace App\Service;

use App\Service\CompanyService\CompanyListAdapterInterface;

class CompanyService
{
    public function __construct(
        protected CompanyListAdapterInterface $companyListAdapter
    ){}

    public function isValidCompanySymbol($companySymbol): bool
    {
        return $this->companyListAdapter
            ->getCompanies()
            ->hasCompanyWithSymbol($companySymbol);
    }
}