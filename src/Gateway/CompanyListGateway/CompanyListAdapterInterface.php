<?php

namespace App\Gateway\CompanyListGateway;

use App\Entity\CompaniesList;

interface CompanyListAdapterInterface
{
    public function getCompanies(): CompaniesList;
}