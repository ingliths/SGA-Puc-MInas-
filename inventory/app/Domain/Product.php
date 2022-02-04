<?php
declare(strict_types=1);
namespace App\Domain;

class Product extends Entity
{
    protected $fillable = [
        'description',
        'price',
        'quantity',
        'category_id',
        'vendor_id',
    ];


    protected function validate(): bool
    {
        return true;
    }
}
