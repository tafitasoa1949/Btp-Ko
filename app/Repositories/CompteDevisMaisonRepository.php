<?php

namespace App\Repositories;

use App\Models\CompteDevisMaison;
use App\Repositories\BaseRepository;

class CompteDevisMaisonRepository extends BaseRepository
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
        return CompteDevisMaison::class;
    }
}
