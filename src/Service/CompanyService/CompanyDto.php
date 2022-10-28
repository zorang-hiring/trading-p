<?php

namespace App\Service\CompanyService;

class CompanyDto
{
    public string $symbol;

    public function __construct(string $symbol)
    {
        $this->symbol = $symbol;
    }
}