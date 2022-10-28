<?php

namespace App\Service;

interface CompanySymbolValidationServiceInterface
{
    public function isValidCompanySymbol($companySymbol): bool;
}