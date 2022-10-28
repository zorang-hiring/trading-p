<?php

namespace App\Service;

use App\Entity\Company;
use DateTimeInterface;

interface QuotesRetrievalServiceInterface
{
    public function retrieveQuotes(Company $company, DateTimeInterface $startDate, DateTimeInterface $endDate);
}