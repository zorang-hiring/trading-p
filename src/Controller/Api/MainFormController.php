<?php

namespace App\Controller\Api;

use Form\MainFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainFormController extends AbstractController
{
    #[Route('/api/main-form', name: 'api_main_form', methods: ['POST'])]
    public function submit(Request $request): Response
    {
        // var_dump($request->request);

        $form = $this->createForm(MainFormType::class, [], [
            'method' => 'POST' // todo needed ?
        ]);

        $form->submit($request->request->all());
        if (!$form->isValid()) {

            $errors = [];
            foreach ($form->getErrors(true) as $k => $error) {
                $errors[$error->getOrigin()->getName()] = [$error->getMessage()];
            }
            return new JsonResponse([
                'status' => 'NOK',
                'message' => 'Invalid Request',
                'errors' => $errors
            ]);
        }
        echo 222;
        // $form->getData() holds the submitted values
        // but, the original `$task` variable has also been updated
        $data = $form->getData();

        return new JsonResponse([


        ]);

//        return new JsonResponse([
//            'status' => 'NOK',
//            'message' => 'Validation error',
//            'errors' => [
//                'companySymbol' => ['Field is required.'],
//                'startDate' => ['Field is required.'],
//                'endDate' => ['Field is required.'],
//                'email' => ['Field is required.']
//            ]
//        ]);
    }
}