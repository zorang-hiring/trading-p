<?php

namespace App\Service;

use App\Service\CompanyHistoryQuotesAdapter\CompanyHistoryQuotesAdapterInterface;
use App\Service\CompanyListAdapter\CompanyListAdapterInterface;
use DateTimeInterface;

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

    public function getQuotes(string $companySymbol, DateTimeInterface $startDate, DateTimeInterface $endDate): array
    {
        $data = $this->companyHistoryQuotesAdapter->getQuotes($companySymbol);

        return [];
    }
}