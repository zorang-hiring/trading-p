<?php

namespace App\Service;

use App\Entity\Company;
use App\Gateway\CompanyListGateway\CompanyListAdapterInterface;

class CompanyService implements CompanyFinderBySymbolServiceInterface
{
    public function __construct(
        protected CompanyListAdapterInterface $companyListAdapter
    ){}

    public function getCompanyBySymbol(string $companySymbol): ?Company
    {
        return $this->companyListAdapter
            ->getCompanies()
            ->findBySymbol($companySymbol);
    }
}