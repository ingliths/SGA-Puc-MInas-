<?php

namespace App\Domain;


class Delivery extends Entity
{
    protected $fillable = [
        'pedido_id',
        'shipping_company',
        'track_code',
    ];


    protected function validate(): bool
    {
        return true;
    }
}
