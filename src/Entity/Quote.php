<?php

namespace App\Entity;

class Quote
{
    public int $date;
    public float $open;
    public float $high;
    public float $low;
    public float $close;
    public int $volume;
}