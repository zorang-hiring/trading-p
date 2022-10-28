<?php

namespace App\Controller\Api;

use App\Service\QuotesRetrievalServiceInterface;
use App\Form\MainFormType;
use App\Service\QuoteRetrievalNotifier\RetrieveCompanyQuotesNotificationDto;
use App\Service\QuoteRetrievalNotifierInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainFormController extends AbstractController
{
    public function __construct(
        protected QuotesRetrievalServiceInterface $companyQuotesService,
        protected QuoteRetrievalNotifierInterface $notifier
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

        $result = new JsonResponse([
            'status' => 'OK',
            'message' => '',
            'errors' => [],
            'data' => $this->companyQuotesService->retrieveQuotes(
                $formData['companySymbol'],
                $formData['startDate'],
                $formData['endDate'],
            )
        ]);

        $this->sendNotification($formData);

        return $result;
    }

    public function buildResponseJsonInvalidForm(FormInterface $form): JsonResponse
    {
        $errors = [];
        foreach ($form->getErrors(true) as $k => $error) {
            $errors[$error->getOrigin()->getName()] = [$error->getMessage()];
        }
        return new JsonResponse([
            'status' => 'NOK',
            'message' => 'Invalid Request',
            'errors' => $errors
        ], 400);
    }

    private function sendNotification(mixed $formData): void
    {
        $notification = new RetrieveCompanyQuotesNotificationDto();
        $notification->recipient = $formData['email'];
        $notification->startDate = $formData['startDate']->format('Y-m-d');
        $notification->endDate = $formData['endDate']->format('Y-m-d');
        $this->notifier->notify($notification);
    }
}