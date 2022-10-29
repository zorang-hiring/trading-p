<?php

namespace App\Controller\Ui;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CompanyQuotesController extends AbstractController
{
    #[Route('/', name: 'ui_company_quotes', methods: ['GET'])]
    public function index(Request $request): Response
    {
        return $this->render('company-quotes.html.twig');
    }
}