<?php

namespace App\Domain;

class TicketEntry extends Entity
{

    protected $fillable = [
        "text"
    ];

    protected function validate(): bool
    {
       return true;
    }
}
