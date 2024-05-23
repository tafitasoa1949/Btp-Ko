<?php

namespace App\Repositories;

use App\Models\Compte;
use App\Repositories\BaseRepository;

class CompteRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'code',
        'nom'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Compte::class;
    }
}
