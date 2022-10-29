<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use DateTimeInterface;

class CompanyQuotesFetcherTypeDto extends AbstractType
{
    public string $companySymbol;
    public ?DateTimeInterface $startDate;
    public ?DateTimeInterface $endDate;
    public string $email;
}