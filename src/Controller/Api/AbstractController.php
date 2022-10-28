<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as SfAbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class AbstractController extends SfAbstractController
{
    protected function buildResponseJsonInvalidForm(FormInterface $form): JsonResponse
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