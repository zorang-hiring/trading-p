<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class ContainsValidCompanySymbol extends Constraint
{
    public string $message = 'The string "{{ string }}" is not valid Company Symbol.';
}