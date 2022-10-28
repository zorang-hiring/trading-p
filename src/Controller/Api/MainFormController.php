<?php

namespace App\Controller\Api;

use Form\MainFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainFormController extends AbstractController
{
    public function __construct(

    )
    {}

    #[Route('/api/main-form', name: 'api_main_form', methods: ['POST'])]
    public function submit(Request $request): Response
    {
        $form = $this->createForm(MainFormType::class);
        $form->submit($request->request->all());
        if (!$form->isValid()) {
            return $this->buildResponseJsonInvalidForm($form);
        }
        echo 222;
        // $form->getData() holds the submitted values
        // but, the original `$task` variable has also been updated
        $data = $form->getData();

        return new JsonResponse([


        ]);

//        return new JsonResponse([
//            'status' => 'OK',
//            'message' => 'Validation error',
//            'errors' => [
//                'companySymbol' => ['Field is required.'],
//                'startDate' => ['Field is required.'],
//                'endDate' => ['Field is required.'],
//                'email' => ['Field is required.']
//            ]
//        ]);
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
}