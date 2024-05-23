<?php

namespace App\Repositories;

use App\Models\Maison;
use App\Repositories\BaseRepository;

class MaisonRepository extends BaseRepository
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
        return Maison::class;
    }
}
