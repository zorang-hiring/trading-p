<?php

namespace App\Service;

use App\Service\CompanyHistoryQuotesAdapter\CompanyHistoryQuotesAdapterInterface;
use App\Service\CompanyListAdapter\CompanyListAdapterInterface;
use DateTimeInterface;
use DateTime;

class QuotesService implements CompanySymbolValidationServiceInterface, QuotesRetrievalServiceInterface
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

    public function retrieveQuotes(string $companySymbol, DateTimeInterface $startDate, DateTimeInterface $endDate): array
    {
        // make precise data range boundaries
        $startDateUnix = $this->dateTimeStringToUnix($startDate->format('Y-m-d 00:00:00'));
        $endDateUnix = $this->dateTimeStringToUnix($endDate->format('Y-m-d 23:59:59'));

        // get and filter results
        $result = [];
        foreach ($this->getHistoryQuotes($companySymbol) as $quote) {
            if ($quote->date < $startDateUnix || $endDateUnix < $quote->date) {
                continue;
            }
            $result[] = $quote;
        }
        return $result;
    }

    /**
     * @param string $dateTime In the form: Y-m-d H:i:s
     * @return int
     * @throws \Exception
     */
    private function dateTimeStringToUnix(string $dateTime): int
    {
        return (new DateTime($dateTime))->getTimestamp();
    }

    private function getHistoryQuotes(string $companySymbol): array
    {
        return $this->companyHistoryQuotesAdapter->getQuotes($companySymbol)->getQuotes();
    }
}