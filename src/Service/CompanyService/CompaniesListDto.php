<?php

namespace App\Service\CompanyService;

class CompaniesListDto
{
    /**
     * @var CompanyDto[]
     */
    protected array $companies = [];

    public function addCompany(CompanyDto $company): void
    {
        $this->companies[] = $company;
    }

    public function hasCompanyWithSymbol(string $companySymbol): bool
    {
        foreach ($this->companies as $company) {
            if ($company->symbol === $companySymbol) {
                return true;
            }
        }
        return false;
    }
}