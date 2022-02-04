<?php
declare(strict_types=1);

namespace App\Domain;

class Category extends Entity
{

    protected $fillable = [
        'name'
    ];

    protected function validate(): bool
    {
        return true;
    }
}
