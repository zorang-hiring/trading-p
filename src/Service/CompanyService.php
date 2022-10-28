<?php

namespace App\Service;

use App\Service\QuotesAdapter\CompanyHistoryQuotesAdapterInterface;
use App\Service\CompanyListAdapter\CompanyListAdapterInterface;
use DateTimeInterface;
use DateTime;

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