<?php

namespace App\Service;

use App\Gateway\CompanyListGateway\CompanyListAdapterInterface;
use App\Gateway\QuotesGateway\CompanyHistoryQuotesAdapterInterface;

class CompanyService implements CompanySymbolValidationServiceInterface
{
    public function __construct(
        protected CompanyListAdapterInterface $companyListAdapter,
        protected CompanyHistoryQuotesAdapterInterface $companyHistoryQuotesAdapter
    ){}

    public function isValidCompanySymbol($companySymbol): bool
    {
        return $this->companyListAdapter
            ->getCompanies()
            ->hasCompanyWithSymbol($companySymbol);
    }
}