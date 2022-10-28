<?php

namespace App\Form;

use App\Dto\RetrieveCompanyQuotesNotificationDto;
use App\Entity\Company;
use App\Service\CompanyFinderBySymbolServiceInterface;
use App\Service\QuotesRetrievalNotifierInterface;
use App\Service\QuotesRetrievalServiceInterface;

class MainFormTypeHandler
{
    public function __construct(
        protected CompanyFinderBySymbolServiceInterface $companyService,
        protected QuotesRetrievalServiceInterface $quotesService,
        protected QuotesRetrievalNotifierInterface $notifier
    ){}

    public function handle(MainFormTypeDto $formData): array
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

    private function sendNotification(MainFormTypeDto $formData, Company $company): void
    {
        $notification = new RetrieveCompanyQuotesNotificationDto();
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