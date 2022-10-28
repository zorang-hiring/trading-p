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

    public function findBySymbol(string $companySymbol): ?Company
    {
        foreach ($this->companies as $company) {
            if ($company->symbol === $companySymbol) {
                return $company;
            }
        }
        return null;
    }
}