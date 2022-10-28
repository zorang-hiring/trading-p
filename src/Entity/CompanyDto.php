<?php

namespace App\Entity;

class CompanyDto
{
    public string $symbol;

    public function __construct(string $symbol)
    {
        $this->symbol = $symbol;
    }
}