<?php

namespace App\Repositories;

use App\Models\Finition;
use App\Repositories\BaseRepository;

class FinitionRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'nom',
        'pourcentage'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Finition::class;
    }
}
