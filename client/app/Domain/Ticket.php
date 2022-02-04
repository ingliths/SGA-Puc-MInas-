<?php

namespace App\Domain;


class Ticket extends Entity
{
    protected $fillable = [
        'pedido_id',
        'description',
        'client',
        'status'
    ];


    function entries(){
        return $this->hasMany(TicketEntry::class);
    }


    protected function validate(): bool
    {
        return true;
    }

}
