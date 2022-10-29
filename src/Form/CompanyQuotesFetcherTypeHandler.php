<?php

namespace App\Form;

use App\Entity\Company;
use App\Gateway\DataRetrievalNotifier\QuotesRetrievalNotificationDto;
use App\Gateway\DataRetrievalNotifier\QuotesRetrievalNotifierInterface;
use App\Service\CompanyFinderBySymbolServiceInterface;
use App\Service\QuotesRetrievalServiceInterface;

class CompanyQuotesFetcherTypeHandler
{
    public function __construct(
        protected CompanyFinderBySymbolServiceInterface $companyService,
        protected QuotesRetrievalServiceInterface $quotesService,
        protected QuotesRetrievalNotifierInterface $notifier
    ){}

    public function handle(CompanyQuotesFetcherTypeDto $formData): array
    {
        $company = $this->getCompany($formData->companySymbol);

        $result = $this->quotesService->retrieveQuotes(
            $company,
            $formData->startDate,
            $formData->endDate,
        );

        $this->sendNotification($formData, $company);

        return $result;
    }

    private function sendNotification(CompanyQuotesFetcherTypeDto $formData, Company $company): void
    {
        $notification = new QuotesRetrievalNotificationDto();
        $notification->forCompanyName = $company->name;
        $notification->recipient = $formData->email;
        $notification->startDate = $formData->startDate->format('Y-m-d');
        $notification->endDate = $formData->endDate->format('Y-m-d');
        $this->notifier->notify($notification);
    }

    private function getCompany(string $companySymbol): ?Company
    {
        return $this->companyService->getCompanyBySymbol($companySymbol);
    }
}