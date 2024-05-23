<?php

namespace App\Repositories;

use App\Models\DetailMaison;
use App\Repositories\BaseRepository;

class DetailMaisonRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'description'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return DetailMaison::class;
    }
}
