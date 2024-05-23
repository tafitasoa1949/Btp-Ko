<?php

namespace App\Repositories;

use App\Models\Unite;
use App\Repositories\BaseRepository;

class UniteRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'nom'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Unite::class;
    }
}
