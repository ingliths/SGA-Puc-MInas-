<?php

namespace App\Domain;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

abstract class Entity extends Model
{
    public $incrementing = false;
    public $keyType = 'string';


    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    /**
     * @return \Ramsey\Uuid\UuidInterface|string
     */
    public function setId()
    {
        $this->setAttribute('id', Str::uuid());
    }

    /**
     * @return bool
     */

    abstract protected function validate(): bool;


    public function save(array $data = []): bool
    {
        $this->fill($data);
        if (!$this->validate()) throw new \Exception('Cannot save');
        if (!$this->id) {
            $this->setId();
        }
        return parent::save();
    }


}
