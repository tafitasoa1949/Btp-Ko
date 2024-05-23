<?php

namespace App\Repositories;

use App\Models\DetailDevis;
use App\Repositories\BaseRepository;

class DetailDevisRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'quantite'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return DetailDevis::class;
    }
}
