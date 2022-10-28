<?php

namespace App\Gateway\CompanyList;

use App\Entity\CompaniesList;

class DataHubNasdaqCompanyListAdapter implements CompanyListAdapterInterface
{
    public function getCompanies(): CompaniesList
    {
        return new CompaniesList();
    }
}