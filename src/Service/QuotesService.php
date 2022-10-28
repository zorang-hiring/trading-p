<?php

namespace App\Service;

use App\Entity\Company;
use App\Gateway\Quotes\CompanyHistoryQuotesAdapterInterface;
use DateTime;
use DateTimeInterface;

class QuotesService implements QuotesRetrievalServiceInterface
{
    public function __construct(
        protected CompanyHistoryQuotesAdapterInterface $companyHistoryQuotesAdapter
    ){}

    public function retrieveQuotes(Company $company, DateTimeInterface $startDate, DateTimeInterface $endDate): array
    {
        // make precise data range boundaries
        $startDateUnix = $this->dateTimeStringToUnix($startDate->format('Y-m-d 00:00:00'));
        $endDateUnix = $this->dateTimeStringToUnix($endDate->format('Y-m-d 23:59:59'));

        // get and filter results
        $result = [];
        foreach ($this->getHistoryQuotes($company->symbol) as $quote) {
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