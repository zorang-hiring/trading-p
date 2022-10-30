<?php

namespace App\Controller\Api;

use App\Form\CompanyQuotesFatcherType;
use App\Form\CompanyQuotesFetcherTypeHandler;
use App\Gateway\DataRetrievalNotifier\QuotesRetrievalNotifierInterface;
use App\Service\CompanyFinderBySymbolServiceInterface;
use App\Service\QuotesRetrievalServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompanyQuotesController extends AbstractController
{
    public function __construct(
        protected CompanyFinderBySymbolServiceInterface $companyService,
        protected QuotesRetrievalServiceInterface $quotesService,
        protected QuotesRetrievalNotifierInterface $notifier,
        protected CompanyQuotesFetcherTypeHandler $formHandler
    ){}

    #[Route('/api/company-quotes', name: 'api_company_quotes', methods: ['GET'])]
    public function fetch(Request $request): Response
    {
        $form = $this->createForm(CompanyQuotesFatcherType::class);
        $form->submit($request->query->all());

        if (!$form->isValid()) {
            return $this->buildResponseJsonInvalidForm($form);
        }

        return new JsonResponse([
            'status' => 'OK',
            'message' => '',
            'errors' => [],
            'data' => $this->formHandler->handle(
                $form->getData()
            )
        ]);
    }
}