<?php

namespace App\Validator;

use App\Service\CompanyFinderBySymbolServiceInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class ContainsValidCompanySymbolValidator extends ConstraintValidator
{
    public function __construct(
        protected CompanyFinderBySymbolServiceInterface $companyService
    )
    {}

    public function validate($value, Constraint $constraint): void
    {
        // custom constraints should ignore null and empty values to allow
        // other constraints (NotBlank, NotNull, etc.) to take care of that
        if (null === $value || '' === $value) {
            return;
        }

        if (!$this->companyService->getCompanyBySymbol($value)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', (string) $value)
                ->addViolation();
        }
    }
}