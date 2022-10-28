<?php

namespace App\Entity;

class Company
{
    public string $symbol;
    public string $name;

    public function __construct(string $symbol, string $name)
    {
        $this->symbol = $symbol;
        $this->name = $name;
    }
}