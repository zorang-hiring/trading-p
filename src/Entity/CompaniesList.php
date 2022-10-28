<?php

namespace App\Entity;

class CompaniesList
{
    /**
     * @var Company[]
     */
    protected array $companies = [];

    public function addCompany(Company $company): void
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