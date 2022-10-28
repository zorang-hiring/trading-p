<?php

namespace App\Entity;

class Company
{
    public string $symbol;

    public function __construct(string $symbol)
    {
        $this->symbol = $symbol;
    }
}