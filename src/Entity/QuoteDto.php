<?php

namespace App\Entity;

class QuoteDto
{
    public int $date;
    public float $open;
    public float $high;
    public float $low;
    public float $close;
    public int $volume;
}