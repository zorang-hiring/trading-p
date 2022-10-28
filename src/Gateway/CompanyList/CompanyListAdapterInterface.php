<?php

namespace App\Gateway\CompanyList;

use App\Entity\CompaniesList;

interface CompanyListAdapterInterface
{
    public function getCompanies(): CompaniesList;
}