<?php

namespace App\Service;

use App\Service\CompanyListAdapter\CompanyListAdapterInterface;

class CompanyService implements CompanySymbolValidationServiceInterface, CompanyHistoryQuotesFetcherServiceInterface
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

    public function getQuotes(string $companySymbol, string $startDate, string $endDate)
    {
        // TODO: Implement getQuotes() method.
    }
}