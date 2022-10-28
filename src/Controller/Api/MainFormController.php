<?php

namespace App\Controller\Api;

use App\Dto\RetrieveCompanyQuotesNotificationDto;
use App\Entity\Company;
use App\Form\MainFormType;
use App\Service\CompanyFinderBySymbolServiceInterface;
use App\Service\QuotesRetrievalNotifierInterface;
use App\Service\QuotesRetrievalServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainFormController extends AbstractController
{
    public function __construct(
        protected CompanyFinderBySymbolServiceInterface $companyService,
        protected QuotesRetrievalServiceInterface $quotesService,
        protected QuotesRetrievalNotifierInterface $notifier
    ){}

    #[Route('/api/main-form', name: 'api_main_form', methods: ['POST'])]
    public function submit(Request $request): Response
    {
        $form = $this->createForm(MainFormType::class);
        $form->submit($request->request->all());

        if (!$form->isValid()) {
            return $this->buildResponseJsonInvalidForm($form);
        }

        $formData = $form->getData();

        $company = $this->companyService->getCompanyBySymbol($formData['companySymbol']);

        $result = new JsonResponse([
            'status' => 'OK',
            'message' => '',
            'errors' => [],
            'data' => $this->quotesService->retrieveQuotes(
                $company,
                $formData['startDate'],
                $formData['endDate'],
            )
        ]);

        $this->sendNotification($formData, $company);

        return $result;
    }

    private function sendNotification(mixed $formData, Company $company): void
    {
        $notification = new RetrieveCompanyQuotesNotificationDto();
        $notification->forCompanyName = $company->name;
        $notification->recipient = $formData['email'];
        $notification->startDate = $formData['startDate']->format('Y-m-d');
        $notification->endDate = $formData['endDate']->format('Y-m-d');
        $this->notifier->notify($notification);
    }
}