<?php

namespace App\Service;

use App\Service\CompanyHistoryQuotesAdapter\CompanyHistoryQuotesAdapterInterface;
use App\Service\CompanyListAdapter\CompanyListAdapterInterface;

class CompanyService implements CompanySymbolValidationServiceInterface, CompanyHistoryQuotesServiceInterface
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

    public function getQuotes(string $companySymbol, string $startDate, string $endDate)
    {
        $data = $this->companyHistoryQuotesAdapter->getQuotes($companySymbol);
    }
}