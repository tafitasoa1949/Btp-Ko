<?php

namespace App\Repositories;

use App\Models\DevisMaison;
use App\Repositories\BaseRepository;

class DevisMaisonRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'duree'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return DevisMaison::class;
    }
}
