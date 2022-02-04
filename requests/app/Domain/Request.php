<?php

namespace App\Domain;

use Illuminate\Database\Eloquent\Model;

class Request extends Entity
{
    protected $fillable = [
        'client',
        'address',
        'status',
        'products',
        'value',
    ];

    protected $casts = [
        'products' => 'array'
    ];

    protected function validate(): bool
    {
        return true;
    }
}
