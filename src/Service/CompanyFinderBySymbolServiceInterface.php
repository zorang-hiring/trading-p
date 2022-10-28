<?php

namespace App\Service;

use App\Entity\Company;

interface CompanyFinderBySymbolServiceInterface
{
    public function getCompanyBySymbol(string $companySymbol): ?Company;
}